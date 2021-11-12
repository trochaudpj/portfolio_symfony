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
trait Timezone
{
    /**
     * Liste des timezone.
     */
    public function getTimezone(): array
    {
        return timezone_identifiers_list();
    }
}
