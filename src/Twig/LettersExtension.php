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
class LettersExtension extends AbstractExtension
{
    /**
     * Function getFunctions.
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('letters', [$this, 'letters']),
        ];
    }

    /**
     * Function letters.
     *
     * @param string $letter comment
     */
    public function letters(string $letter): string
    {
        $letters = [
            'a' => '#1A1A1A',
            'b' => '#980000',
            'c' => '#980056',
            'd' => '#98008B',
            'e' => '#720098',
            'f' => '#560098',
            'g' => '#400098',
            'h' => '#240098',
            'i' => '#000098',
            'j' => '#001998',
            'k' => '#002F98',
            'l' => '#003D98',
            'm' => '#005998',
            'n' => '#006F98',
            'o' => '#008898',
            'p' => '#009881',
            'q' => '#009864',
            'r' => '#009839',
            's' => '#009812',
            't' => '#199800',
            'u' => '#399800',
            'v' => '#599800',
            'w' => '#769800',
            'x' => '#939800',
            'y' => '#987D00',
            'z' => '#985D00',
        ];

        return $letters[strtolower($letter)];
    }
}
