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
trait ClassMethods
{
    /**
     * Public function classMethods()
     * Retourne les noms des méthodes d'une classe.
     *
     * @param object $nameClass Nom de la class intancier
     *                          Ex: $class = new class();
     * @param string $method    null toutes les methodes,
     *                          get retoune les getters,
     *                          set retourne les setters.
     *
     * @return array
     */
    public function classMethods(object $nameClass, string $method = null): array
    {
        $class_methods = get_class_methods(get_class($nameClass));

        if ($method !== null) {
            $methods = [];
            foreach ($class_methods as $name_method) {
                if (substr($name_method, 0, 3) === $method) {
                    array_push($methods, $name_method);
                }
            }
        } else {
            $methods = $class_methods;
        }

        return $methods;
    }
}
