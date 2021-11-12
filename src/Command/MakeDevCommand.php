<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Command;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use App\Entity\User;
use App\Repository\RolesRepository;
use App\Service\Admin\Cli\ColorPHPCliService;
use App\Service\ConfigurationService;
use App\Traits\ActivationKey;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class MakeDevCommand extends Command
{
    use ActivationKey;

    /**
     * Name command.
     *
     * @var string
     */
    protected static $defaultName = 'make:dev';

    /**
     * Variable $this->rolesRepository.
     *
     * @var RolesRepository
     */
    private $rolesRepository;

    /**
     * Variable $this->encoder.
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * Variable $this->em.
     *
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * Variable $this->colors.
     *
     * @var ColorPHPCliService
     */
    private $colors;

    /**
     * Variable $this->configuration.
     *
     * @var ConfigurationService
     */
    private $configuration;

    /**
     * Variable $this->email.
     *
     * @var string
     */
    private $email;

    /**
     * Variable $this->password.
     *
     * @var string
     */
    private $password;

    /**
     * Void __construct().
     */
    public function __construct(RolesRepository $rolesRepository, UserPasswordHasherInterface $encoder, EntityManagerInterface $em, ColorPHPCliService $colors, ConfigurationService $configuration)
    {
        $this->rolesRepository = $rolesRepository;
        $this->encoder = $encoder;
        $this->em = $em;
        $this->colors = $colors;
        $this->configuration = $configuration;
        parent::__construct();
    }

    /**
     * Function configure().
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setDescription('Créer un compte dev')
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
    private function askEmail(InputInterface $input, OutputInterface $output)
    {
        $ask = $this->colors->getColoredString("Email du dev:\n", 'green');
        $helper = $this->getHelper('question');
        $question = new Question($ask);
        $email = $helper->ask($input, $output, $question);

        $email = strip_tags(trim(htmlspecialchars($email, ENT_QUOTES)));
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->askEmail($input, $output);
        } else {
            $this->email = $email;
        }
    }


    /**
     * Function askPassword().
     *
     * @param InputInterface  $input  comment
     * @param OutputInterface $output comment
     *
     * @return void
     */
    private function askPassword(InputInterface $input, OutputInterface $output)
    {
        $ask = $this->colors->getColoredString("Mot de passe du dev:\n", 'green');
        $helper = $this->getHelper('question');
        $question = new Question($ask);
        $password = $helper->ask($input, $output, $question);

        $password = strip_tags(trim(htmlspecialchars($password, ENT_QUOTES)));
        if (empty($password)) {
            $this->askEmail($input, $output);
        } else {
            $this->password = $password;
        }
    }

    /**
     * Function askPseudo().
     *
     * @param InputInterface  $input  comment
     * @param OutputInterface $output comment
     *
     * @return void
     */
    private function askPseudo(InputInterface $input, OutputInterface $output)
    {
        $ask = $this->colors->getColoredString("Pseudo du dev:\n", 'green');
        $helper = $this->getHelper('question');
        $question = new Question($ask);
        $pseudo = $helper->ask($input, $output, $question);

        $pseudo = strip_tags(trim(htmlspecialchars($pseudo, ENT_QUOTES)));
        if (empty($pseudo)) {
            $this->askPseudo($input, $output);
        } else {
            $this->pseudo = $pseudo;
        }
    }


    /**
     * Undocumented function.
     *
     * @param InputInterface  $input  comment
     * @param OutputInterface $output comment
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->askEmail($input, $output);
        $this->askPassword($input, $output);
        $this->askPseudo($input, $output);

        // TimeZone
        date_default_timezone_set('Europe/Paris');

        $user = new User();
        $user->setRole($this->rolesRepository->findOneBy(['role' => 'ROLE_DEV']));
        $user->setRoles(['ROLE_DEV']);
        $user->setEmail($this->email);
        $user->setPassword($this->encoder->hashPassword($user, $this->password));
        $user->setIsActive(true);
        $user->setSecurity(sha1($this->activationKey($this->email)));
        $user->setLocale('fr');
        $user->setTimezone('Europe/Paris');
        $user->setPseudo($this->pseudo);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln($this->colors->getColoredString("\n\n     ".utf8_decode('Compte dev crée')."     \n", 'white', 'green')."\n");

        return 0;
    }
}
