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

namespace App\Service\Image;

/*
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

use App\Traits\File;

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
class ResizeImage
{
    use File;

    /**
     * Redimensionne une photo.
     *
     * @param string $target    chemin absolue de l'image
     * @param int    $newWidth  définition de la largeur maximale
     * @param int    $newHeight définition de la hauteur maximale
     *
     * @return void
     */
    public function resize(string $target, int $newWidth, int $newHeight)
    {
        if ($this->fileExist($target) === true) {
            // extension du fichier image
            $extension = pathinfo($target, PATHINFO_EXTENSION);

            // récupération des dimension de l'image source
            list($widthOrig, $heightOrig) = getimagesize($target);

            // Calcul des nouvelles dimensions
            $ratio_orig = $widthOrig / $heightOrig;
            if ($newWidth / $newHeight > $ratio_orig) {
                $newWidth = $newHeight * $ratio_orig; // mode portait
            } else {
                $newHeight = $newWidth / $ratio_orig; // mode paysage
            }

            // création d'une image vide
            $imDestination = imagecreatetruecolor($newWidth, $newHeight);

            // création de l'image à partir de la source
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $imSource = imagecreatefromjpeg($target);
                    // copie de l'image avec redimensionnement
                    if (imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $newWidth, $newHeight, $widthOrig, $heightOrig)) {
                        imagejpeg($imDestination, $target, 100);
                    }
                break;
                case 'png':
                    $imSource = imagecreatefrompng($target);
                    // copie de l'image avec redimensionnement
                    if (imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $newWidth, $newHeight, $widthOrig, $heightOrig)) {
                        imagealphablending($imDestination, false);
                        imagesavealpha($imDestination, true);
                        imagepng($imDestination, $target, 9);
                    }
                break;
            }

            imagedestroy($imDestination);
            imagedestroy($imSource);
        }
    }
}
