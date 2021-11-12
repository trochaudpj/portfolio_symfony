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

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Yaml\Yaml;
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
class SocieteService
{
    /**
     * Variable $this->translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Variable $this->file.
     *
     * @var string
     */
    private $file;

    /**
     * Void __construct().
     *
     * @param ParameterBagInterface $params     comment
     * @param TranslatorInterface   $translator comment
     */
    public function __construct(ParameterBagInterface $params, TranslatorInterface $translator)
    {
        $this->translator = $translator;
        $this->file = $params->get('app_root').'/config/societe.yaml';
    }

    /**
     * Retourne un tableau de la societe.
     */
    public function get(): array
    {
        $societe = [];

        if (\file_exists($this->file)) {
            $societe = Yaml::parseFile($this->file);
        }

        return $societe;
    }

    /**
     * Update le fichier de la societe.
     *
     * @param array $post comment
     */
    public function update(array $post): array
    {
        $societe = $this->get();

        foreach ($post as $key => $option) {
            foreach ($option['tabs'] as $column => $value) {
                $societe[$key]['tabs'][$column]['value'] = $post[$key]['tabs'][$column]['value'];
            }
        }

        file_put_contents($this->file, Yaml::dump($societe));
        exec('rm -R var/cache');

        return [
            'code' => 'success',
            'message' => $this->translator->trans('SOCIETE-UPDATE'),
        ];
    }
}
