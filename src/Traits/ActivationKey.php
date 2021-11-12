<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category Raptor\Traits
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Traits;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category Raptor\Traits
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
trait ActivationKey
{
    /**
     * Activation key.
     *
     * @param string $email comment
     *
     * @return string
     */
    public function activationKey(string $email): string
    {
        $activationKey = date('Y/m/d H:i:s').'|**|'.$email;
        $activationKey = password_hash($activationKey, PASSWORD_DEFAULT);
        $activationKey = str_replace('/', '', $activationKey);
        $activationKey = sha1($activationKey);

        return $activationKey;
    }
}
