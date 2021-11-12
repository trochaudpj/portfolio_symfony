<?php

namespace App\Command;

use App\Service\Admin\Cli\ColorPHPCliService;
use App\Service\ConfigurationService;
use App\Traits\File;
use App\Traits\Folder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeTemplateControllerCommand extends Command
{
    use File;
    use Folder;

    private $app_root;
    protected static $defaultName = 'make:template:controller';
    protected static $defaultDescription = 'Créer un controller et la vue associée au thème';

    public function __construct(string $kernelProjectDir, ColorPHPCliService $colors, ConfigurationService $configuration)
    {
        $this->app_root = $kernelProjectDir;
        $this->colors = $colors;
        $this->configuration = $configuration;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * Function askEmail().
     *
     * @param InputInterface  $input  comment
     * @param OutputInterface $output comment
     *
     * @return void
     */
    private function askController(InputInterface $input, OutputInterface $output)
    {
        $ask = $this->colors->getColoredString('Nom du controller (e.g. ', 'green');
        $ask .= $this->colors->getColoredString('ExpertController', 'yellow');
        $ask .= $this->colors->getColoredString("):\n", 'green');
        $helper = $this->getHelper('question');
        $question = new Question($ask);
        $controller = $helper->ask($input, $output, $question);

        $controller = strip_tags(trim(htmlspecialchars($controller, ENT_QUOTES)));
        if (empty($controller)) {
            $this->askController($input, $output);
        }

        return $controller;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $arg1 = $input->getArgument('arg1');
        if (!$arg1) {
            $controller = $this->askController($input, $output);
        } else {
            $controller = strip_tags(trim(htmlspecialchars($arg1, ENT_QUOTES)));
        }

        if (is_string($controller)) {
            $template = strtolower(str_replace('Controller', '', $controller));
            $controller = ucfirst(str_replace('Controller', '', $controller).'Controller');

            // CONTROLLER
            $file = $this->app_root.'/src/Controller/'.$controller.'.php';
            if (\file_exists($file)) {
                $io->error("Le controller {$controller} existe déjà !!");

                return Command::FAILURE;
            } else {
                $create = "<?php\n";
                $create .= "\n";
                $create .= "namespace App\Controller;\n";
                $create .= "\n";
                $create .= "use Symfony\Component\HttpFoundation\Response;\n";
                $create .= "use Symfony\Component\Routing\Annotation\Route;\n";
                $create .= "\n";
                $create .= "class {$controller} extends BaseController\n";
                $create .= "{\n";
                $create .= "\t/**\n";
                $create .= "\t * @Route(\"/{$template}\", name=\"{$template}\")\n";
                $create .= "\t */\n";
                $create .= "\tpublic function index(): Response\n";
                $create .= "\t{\n";
                $create .= "\t\treturn \$this->template('{$template}/index.html.twig', [\n";
                $create .= "\t\t\t'controller_name' => '".$controller."',\n";
                $create .= "\t\t]);\n";
                $create .= "\t}\n";
                $create .= "}\n";

                $this->fwrite($file, $create);
                $created_controller = true;
            }

            // TEMPLATES + index.html.twig
            $theme = $this->configuration->get('site', 'template');
            $folder = $this->app_root.'/templates/'.$theme.'/'.$template;
            $this->folderCreate($folder);

            $file = $folder.'/index.html.twig';
            if (\file_exists($file)) {
                $io->error("Le dossier du template {$file} existe déjà !!");

                return Command::FAILURE;
            } else {
                $create = "{% extends template ~ '/base.html.twig' %}\n";
                $create .= "\n";
                $create .= "{% block title %}{{ controller_name }}{% endblock %}\n";
                $create .= "\n";
                $create .= "{% block body %}\n";
                $create .= "<style>\n";
                $create .= "\t.example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }\n";
                $create .= "\t.example-wrapper code { background: #F5F5F5; padding: 2px 6px; }\n";
                $create .= "</style>\n";
                $create .= "\n";
                $create .= "<div class=\"example-wrapper\">\n";
                $create .= "\t<h1>Hello {{ controller_name }}! ✅</h1>\n";
                $create .= "\t\n";
                $create .= "\tThis friendly message is coming from:\n";
                $create .= "\t<ul>\n";
                $create .= "\t\t<li>Your controller at <code><a href=\"".$this->app_root.'/src/Controller/'.$controller.'.php">src/Controller/'.$controller.".php</a></code></li>\n";
                $create .= "\t\t<li>Your template at <code><a href=\"".$this->app_root.'/templates/'.$theme.'/'.$template.'/index.html.twig">templates/'.$theme.'/'.$template."/index.html.twig</a></code></li>\n";
                $create .= "\t</ul>\n";
                $create .= "</div>\n";
                $create .= "{% endblock %}\n";
                $create .= "\n";

                $this->fwrite($file, $create);
                $created_twig = true;
            }

            if (isset($created_controller) || isset($created_twig)) {
                echo "\n";
            }
            if (isset($created_controller)) {
                echo $this->colors->getColoredString('créé', 'blue').': ';
                echo 'src/Controller/'.$controller.'.php';
                echo "\n";
            }
            if (isset($created_twig)) {
                echo $this->colors->getColoredString('créé', 'blue').': ';
                echo 'templates/'.$theme.'/'.$template.'/index.html.twig ';
                echo "\n";
            }
            if (isset($created_controller) || isset($created_twig)) {
                $io->success('SUCCESS ');

                return Command::SUCCESS;
            } else {
                $io->error('ERROR ');

                return Command::FAILURE;
            }
        }

        $io->error('Une erreur est survenue !!');

        return Command::FAILURE;
    }
}
