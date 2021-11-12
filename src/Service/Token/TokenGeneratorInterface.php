<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Service
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Service\Token;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Service
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
interface TokenGeneratorInterface
{
    /**
     * Undocumented function.
     *
     * @param int $length comment
     *
     * @return void
     */
    public function _generate(int $length);

    /**
     * Undocumented function.
     *
     * @return void
     */
    public function setSession();

    /**
     * Function getToken().
     *
     * @return string
     */
    public function getToken();
}
