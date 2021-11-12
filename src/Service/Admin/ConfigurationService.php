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
class ConfigurationService
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
        $this->file = $params->get('app_root').'/config/configuration.yaml';
    }

    /**
     * Retourne un tableau de la configuration du site.
     */
    public function get(): array
    {
        $configuration = [];

        if (\file_exists($this->file)) {
            $configuration = Yaml::parseFile($this->file);
        }

        return $configuration;
    }

    /**
     * Update le fichier de configuration du site.
     *
     * @param array $post comment
     */
    public function update(array $post): array
    {
        $configuration = $this->get();

        foreach ($post as $key => $option) {
            foreach ($option['tabs'] as $column => $value) {
                $configuration[$key]['tabs'][$column]['value'] = $post[$key]['tabs'][$column]['value'];
            }
        }

        file_put_contents($this->file, Yaml::dump($configuration));
        exec('rm -R var/cache');

        return [
            'code' => 'success',
            'message' => $this->translator->trans('CONFIGURATION-UPDATE'),
        ];
    }

    /**
     * Undocumented function.
     *
     * @param string $key    comment
     * @param string $option comment
     *
     * @return void
     */
    public function getKey(string $key, string $option)
    {
        $configuration = $this->get();

        return $configuration[$key]['tabs'][$option]['value'];
    }
}
