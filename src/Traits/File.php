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
trait File
{
    /**
     * Change le mode d'un fichier — chmod.
     *
     * @param string $path  comment
     * @param int    $chmod comment
     *
     * @return boolean
     */
    public function fileChmod(string $path, int $chmod = 0755): bool
    {
        return chmod($path, $chmod);
    }

    /**
     * Function qui ouvre un fichier
     * et écris dans le fichier.
     *
     * @param string $target comment
     * @param string $text   comment
     */
    public function fwrite(string $target, string $text)
    {
        $fichier = fopen($target, 'w+');
        fwrite($fichier, $text);
        fclose($fichier);
    }

    /**
     * Supprime un fichier.
     *
     * @param string $target lien absolue du fichier
     *
     * @return boolean
     */
    public function fileUnlink(string $target): bool
    {
        if (\file_exists($target)) {
            unlink($target);
        }

        return !\file_exists($target) ? false : true;
    }

    /**
     * Teste si un fichier existe.
     *
     * @param string $target lien absolue du fichier
     *
     * @return boolean
     */
    public function fileExist(string $target): bool
    {
        return \file_exists($target) ? true : false;
    }
}
