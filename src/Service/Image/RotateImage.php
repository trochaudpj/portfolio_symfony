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
class RotateImage
{
    use File;

    /**
     * Tourne la photo uploader.
     *
     * @param string $source chemin absolue de l'image
     *
     * @return void
     */
    public function rotate(string $source)
    {
        if ($this->fileExist($source) === true) {
            // extension du fichier image
            $extension = pathinfo($source, PATHINFO_EXTENSION);

            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $src = imagecreatefromjpeg($source);
                break;
                case 'png':
                    $src = imagecreatefrompng($source);
                break;
            }

            $exif = exif_read_data($source);
            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 8:
                        $rotation = imagerotate($src, 90, 0);
                    break;
                    case 3:
                        $rotation = imagerotate($src, 180, 0);
                    break;
                    case 6:
                        $rotation = imagerotate($src, -90, 0);
                    break;
                }
            }

            if (isset($rotation)) {
                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                        imagejpeg($rotation, $source);
                    break;
                    case 'png':
                        imagepng($rotation, $source);
                    break;
                }
                imagedestroy($rotation);
            }

            imagedestroy($src);
        }
    }
}
