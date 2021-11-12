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

namespace App\Service;

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

use App\Service\Image\ResizeImage;
use App\Traits\Folder;
use App\Traits\FormText;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Contracts\Translation\TranslatorInterface;

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
class UploadService
{
    use Folder;
    use FormText;

    /**
     * ParameterBagInterface.
     *
     * @var objet
     */
    private $_params;

    /**
     * TranslatorInterface.
     *
     * @var objet
     */
    private $_translator;

    /**
     * Chemin absolue du dossier pour uploader.
     *
     * @var string
     */
    private $_folder;

    /**
     * Nom du fichier renommer.
     *
     * @var string
     */
    private $_renameFile;

    /**
     * Type de fichier
     * photo, vidéo, zip, autre.
     *
     * @var string
     */
    private $_type;

    /**
     * Nom de l'album photo ou vidéo.
     *
     * @var string
     */
    private $_album;

    /**
     * Extensions autorisées.
     *
     * @var array
     */
    private $_extensions;

    /**
     * Extension du fichier uploader.
     *
     * @var string
     */
    private $_extension_file;

    /**
     * Mimes autorisées.
     *
     * @var array
     */
    private $_mimes;

    /**
     * Largeur min image upload.
     *
     * @var integer
     */
    private $_minWidth;

    /**
     * Hauteur min image upload.
     *
     * @var integer
     */
    private $_minHeight;

    /**
     * Largeur max image upload.
     *
     * @var integer
     */
    private $_maxWidth;

    /**
     * Hauteur max image upload.
     *
     * @var integer
     */
    private $_maxHeight;

    /**
     * Type de rename pour le fichier uploader.
     *
     * @var string|null
     */
    private $_rename;

    /**
     * Permet le redimensionnement d'une image.
     *
     * @var bool
     */
    private $_resize = false;

    /**
     * Original name file upload.
     *
     * @var string
     */
    private $_originalName;

    /**
     * Void __construct().
     *
     * @param ParameterBagInterface $params     comment
     * @param TranslatorInterface   $translator comment
     */
    public function __construct(ParameterBagInterface $params, TranslatorInterface $translator)
    {
        $this->_params = $params;
        $this->_translator = $translator;
    }

    /**
     * Setter.
     *
     * @param string $target     chemin du dossier pour uploader
     * @param string $type       photos, vidéos, zip... etc etc
     * @param array  $mimes      mimes type autorisées a uploader
     * @param array  $extensions type d'extensions autorisées a uploader
     */
    public function setFolder(string $target, string $type, array $mimes = [], array $extensions = [])
    {
        $root = $this->_params->get('app_root');
        $tab = explode('/', $target);

        $next = '';
        foreach ($tab as $doc) {
            $this->folderCreate($root.'/'.$next.$doc, 0755, true, true);
            $next .= $doc.'/';
        }

        $this->_folder = $root.'/'.$target;
        $this->_type = $type;
        $this->_album = $tab[(count($tab) - 1)];
        $this->_mimes = !empty($mimes) ? $mimes : $this->_params->get('mimeType'.ucfirst(strtolower($type)));
        $this->_extensions = !empty($extensions) ? $extensions : $this->_params->get('extensions'.ucfirst(strtolower($type)));
    }

    /**
     * Getter
     * Chemin absolue du fichier uploader.
     *
     * @return string
     */
    public function getFolder(): string
    {
        return $this->_folder;
    }

    /**
     * Get largeur min image upload.
     *
     * @return integer
     */
    public function getMinWidth(): int
    {
        return $this->_minWidth;
    }

    /**
     * Set largeur min image upload.
     *
     * @param int $minWidth Largeur min image upload.
     *
     * @return self
     */
    public function setMinWidth($minWidth): self
    {
        $this->_minWidth = $minWidth;

        return $this;
    }

    /**
     * Get hauteur min image upload.
     *
     * @return integer
     */
    public function getMinHeight(): int
    {
        return $this->_minHeight;
    }

    /**
     * Set hauteur min image upload.
     *
     * @param int $minHeight Hauteur min image upload.
     *
     * @return self
     */
    public function setMinHeight($minHeight): self
    {
        $this->_minHeight = $minHeight;

        return $this;
    }

    /**
     * Setter
     * Si le type est une image, largeur maximal de l'image a uploader.
     *
     * @param int $maxWidth largeur max
     *
     * @return void
     */
    public function setMaxWidth(int $maxWidth)
    {
        $this->_maxWidth = $maxWidth;
    }

    /**
     * Getter
     * Si le type est une image, largeur maximal de l'image a uploader.
     *
     * @return integer
     */
    public function getMaxWidth(): int
    {
        return $this->_maxWidth;
    }

    /**
     * Setter
     * Si le type est une image, hauteur maximal de l'image a uploader.
     *
     * @param int $maxHeight hauteur max
     *
     * @return void
     */
    public function setMaxHeight(int $maxHeight)
    {
        $this->_maxHeight = $maxHeight;
    }

    /**
     * Getter
     * Si le type est une image, hauteur maximal de l'image a uploader.
     *
     * @return integer
     */
    public function getMaxHeight(): int
    {
        return $this->_maxHeight;
    }

    /**
     * Get permet le redimensionnement d'une image.
     *
     * @return bool
     */
    public function getResize(): bool
    {
        return $this->_resize;
    }

    /**
     * Set permet le redimensionnement d'une image.
     *
     * @param bool $resize Permet le redimensionnement d'une image
     *
     * @return self
     */
    public function setResize(bool $resize): self
    {
        $this->_resize = $resize;

        return $this;
    }

    /**
     * Get nom du fichier renommer.
     *
     * @return string
     */
    public function getRenameFile(): string
    {
        return $this->_renameFile;
    }

    /**
     * Set nom du fichier renommer.
     *
     * @return self
     */
    private function setRenameFile(): self
    {
        if (null === $this->getRename() || $this->getRename() === '' || $this->getRename() === 'encoder') {
            $renameFile = '|*|';
            $renameFile .= $this->_album;
            $renameFile .= '|-|';
            $renameFile .= date('Y/m/d H:i:s');
            $renameFile .= '|*|';
            $renameFile = sha1($renameFile);
        } elseif ($this->getRename() === 'original') {
            $renameFile = $this->getOriginalName();
        } else {
            $renameFile = $this->slug($this->getRename());
        }

        $this->_renameFile = $renameFile.'.'.$this->getExtensionFile();

        return $this;
    }

    /**
     * Nom de sortie du fichier uploader.
     *
     * @return string|null
     */
    public function getRename()
    {
        return $this->_rename;
    }

    /**
     * Nom de sortie du fichier uploader.
     *
     * 1- encoder: encode le nom le nom du fichier en sha1
     * 2- original: garde le nom original du fichier uploader
     * 3- renomme le fichier sous le nom voulu.
     *
     * @param string $argument encoder, original ou nom du fichier voulu (ex: avatar)
     *
     * @return self
     */
    public function setRename(string $argument): self
    {
        $this->_rename = $argument;

        return $this;
    }

    /**
     * Get extension du fichier uploader.
     *
     * @return string
     */
    public function getExtensionFile(): string
    {
        return $this->_extension_file;
    }

    /**
     * Set extension du fichier uploader.
     *
     * @param string $extension_file Extension du fichier uploader.
     *
     * @return self
     */
    public function setExtensionFile(string $extension_file): self
    {
        $this->_extension_file = $extension_file;

        return $this;
    }

    /**
     * Get the value of _originalName.
     */
    public function getOriginalName(): string
    {
        return $this->_originalName;
    }

    /**
     * Set the value of _originalName.
     *
     * @return self
     */
    public function setOriginalName($originalName): self
    {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $this->_originalName = $this->slug(
            str_replace('.'.$extension, '', $originalName)
        );

        return $this;
    }

    /**
     * Upload.
     *
     * @param object $file tableau $_FILES
     *
     * @return array
     */
    public function upload(object $file): array
    {
        // Si object vide
        if (empty($file)) {
            $return['type'] = 'error';
            $return['msg'] = $this->_translator->trans('ERROR-UPLOAD');

            return $return;

        // Si errors
        } elseif ($file->getError() != 0) {
            $return['type'] = 'error';
            $return['msg'] = $this->_translator->trans('ERROR-UPLOAD');

            return $return;

        // Si mauvaise extension
        } elseif (!in_array($file->guessExtension(), $this->_extensions) && !in_array($file->getMimeType(), $this->_mimes)) {
            $return['type'] = 'error';
            $return['msg'] = $this->_translator->trans('ERROR-UPLOAD-FORMAT', [
                '%format%', implode(',', $this->_extensions),
            ]);

            return $return;
        } else {
            // Si type image, recupere les dimension de celle ci
            // teste si l'image uploader est plus petite que les dimensions minimums voulus
            $image_data = $this->_type === 'photos' ? getimagesize($file->getRealPath()) : '';
            if ($this->_type === 'photos' && $image_data[0] < $this->_minWidth && $image_data[0] >= $image_data[1] || $image_data[1] < $this->_minHeight && $image_data[1] >= $image_data[0]) {
                $return['type'] = 'warning';
                $return['msg'] = $this->_translator->trans('SMALL-PICTURE');

                return $return;

            // autre type de fichier
            } else {
                // Extension du fichier uploader
                $extension = $file->guessExtension();
                $this->setExtensionFile($extension);
                // Nom original du fichier uploader
                $this->setOriginalName($file->getClientOriginalName());
                // nom du fichier de sortie
                $this->setRenameFile();

                try {
                    $file->move(
                        $this->_folder,
                        $this->getRenameFile()
                    );
                    if ($this->_type === 'photos') {
                        // Si l'image uploader est plus grande que les dimensions maximum voulus
                        // Elle est redimensionner aux dimensions maximum
                        if ($this->getResize() === true && $image_data[0] > $this->_maxWidth && $image_data[0] <= $image_data[1] || $this->getResize() === true && $image_data[1] > $this->_maxHeight && $image_data[1] <= $image_data[0]) {
                            $image = new ResizeImage();
                            $image->resize($this->_folder.'/'.$this->getRenameFile(), $this->_maxWidth, $this->_maxHeight);
                        }
                        $key_trans = 'PHOTO-SAVE';
                    }
                    if ($this->_type === 'videos') {
                        $key_trans = 'VIDEO-SAVE';
                    }

                    $return['type'] = 'success';
                    $return['msg'] = $this->_translator->trans($key_trans, [
                        '%album' => $this->_album,
                    ]);

                    return $return;
                } catch (FileException $e) {
                    $return['type'] = 'error';
                    $return['msg'] = $e;

                    return $return;
                }
            }
        }
    }
}
