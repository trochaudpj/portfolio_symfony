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

namespace App\Service\Admin;

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

use MatthiasMullie\Minify;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

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
final class MinifyService
{
    /**
     * Variable $this->_root.
     *
     * @var string
     */
    private $_root;

    /**
     * Variable $this->_docs_css.
     *
     * @var array
     */
    private $_docs_css;

    /**
     * Variable $this->_docs_js.
     *
     * @var array
     */
    private $_docs_js;

    /**
     * Void __construct().
     *
     * @param ParameterBagInterface $params comment
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->_root = $params->get('app_root');
        $this->_docs_css = $params->get('minify_css');
        $this->_docs_js = $params->get('minify_js');
    }

    /**
     * Public function css().
     */
    public function css(): array
    {
        $css = [];
        if (!empty($this->_docs_css)) {
            foreach ($this->_docs_css as $dossier) {
                $css[$dossier] = [];
                $target = $this->_root.'/'.$dossier;
                if (is_dir($target)) {
                    $filename = scandir($target);
                    for ($i = 0; $i < count($filename); ++$i) {
                        $extension = pathinfo($filename[$i], PATHINFO_EXTENSION);
                        if ($extension === 'css') {
                            if (substr($filename[$i], -7, 3) !== 'min') {
                                $minifier = new Minify\CSS($this->_root.'/'.$dossier.'/'.$filename[$i]);
                                $new_filename = str_replace('.'.$extension, '.min.css', $filename[$i]);
                                $minifier->minify($this->_root.'/'.$dossier.'/'.$new_filename);
                                $css[$dossier][$filename[$i]] = $new_filename;
                            }
                        }
                    }
                }
            }
        }

        return $css;
    }

    /**
     * Public function js().
     */
    public function js(): array
    {
        $js = [];
        if (!empty($this->_docs_js)) {
            foreach ($this->_docs_js as $dossier) {
                $js[$dossier] = [];
                $target = $this->_root.'/'.$dossier;
                if (is_dir($target)) {
                    $filename = scandir($target);
                    for ($i = 0; $i < count($filename); ++$i) {
                        $extension = pathinfo($filename[$i], PATHINFO_EXTENSION);
                        if ($extension === 'js') {
                            if (substr($filename[$i], -6, 3) !== 'min') {
                                $minifier = new Minify\JS($this->_root.'/'.$dossier.'/'.$filename[$i]);
                                $new_filename = str_replace('.'.$extension, '.min.js', $filename[$i]);
                                $minifier->minify($this->_root.'/'.$dossier.'/'.$new_filename);
                                $js[$dossier][$filename[$i]] = $new_filename;
                            }
                        }
                    }
                }
            }
        }

        return $js;
    }
}
