<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Twig
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Twig;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Twig
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Twig
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class AgeExtension extends AbstractExtension
{
    /**
     * Variable $this->_translator.
     *
     * @var TranslatorInterface
     */
    private $_translator;

    /**
     * Void __construct().
     *
     * @param TranslatorInterface $translator comment
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->_translator = $translator;
    }

    /**
     * Undocumented function.
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('age', [$this, 'age']),
        ];
    }

    /**
     * Retourne l'age de l'utilisateur
     * a partir de sa date de naissance.
     *
     * @param string $date_naissance (date de naissance de l'utilisateur)
     */
    public function age($date_naissance): string
    {
        $am = explode('/', date_format($date_naissance, 'd/m/Y'));
        $an = explode('/', date('d/m/Y'));

        if (($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0]))) {
            $age = $an[2] - $am[2];
        } else {
            $age = $an[2] - $am[2] - 1;
        }

        return $this->_translator->trans('AGE', ['age%' => $age]);
    }
}
