<?php

namespace App\Command;

use App\Service\Admin\Cli\ColorPHPCliService;
use App\Service\Admin\MinifyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MinifyCommand extends Command
{
    protected static $defaultName = 'make:minify';

    /**
     * Variable $this->_minifyService.
     *
     * @var MinifyService
     */
    private $_minifyService;

    /**
     * Void __construct().
     *
     * @param MinifyService $minifyService comment
     */
    public function __construct(MinifyService $minifyService, ColorPHPCliService $colors)
    {
        $this->_minifyService = $minifyService;
        $this->_colors = $colors;
        parent::__construct();
    }

    private function _return(array $dossiers): string
    {
        $return = '';
        if (!empty($dossiers)) {
            $d = 0;
            foreach ($dossiers as $docs => $files) {
                if ($d > 0) {
                    $return .= "\n";
                }
                $return .= $this->_colors->getColoredString($docs, 'green')."\n";
                if (!empty($files)) {
                    $i = 0;
                    foreach ($files as $k => $v) {
                        $return .= $i.'. '.$k.' => '.$v."\n";
                        ++$i;
                    }
                } else {
                    $return .= "Aucun fichier traité\n";
                }
                ++$d;
            }
        }

        return $return;
    }

    protected function configure()
    {
        $this
            ->setDescription('Minify css or js file')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $msg = '';
        $return = '';

        if ($arg1) {
            switch ($arg1) {
                case 'css':
                    $file_css = $this->_minifyService->css();
                    $msg = 'Le ou les dossier(s) CSS suivant, ont bien été minifiés';
                    $return = $this->_return($file_css);
                    $io->success($msg);
                    echo $return;
                break;
                case 'js':
                    $file_js = $this->_minifyService->js();
                    $msg = 'Le ou les dossier(s) JS suivant, ont bien été minifiés';
                    $return = $this->_return($file_js);
                    $io->success($msg);
                    echo $return;
                break;
                case 'css-js':
                    $file_css = $this->_minifyService->css();
                    $file_js = $this->_minifyService->js();
                    $msg = 'Le ou les dossier(s) CSS & JS suivant, ont bien été minifiés';
                    $return = $this->_return($file_css);
                    $return .= "\n";
                    $return .= $this->_return($file_js);
                    $io->success($msg);
                    echo $return;
                break;
                default:
                    $io->error('argument de dossier non reconnu');
                break;
            }
        }

        if ($input->getOption('option1')) {
            // ...
        }

        return 0;
    }
}
