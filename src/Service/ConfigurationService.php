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

use App\Service\Admin\TranslationService;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Yaml\Yaml;

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
     * Variable $this->configuration.
     *
     * @var array
     */
    private $configuration = [];

    /**
     * Variable  $this->translationService.
     *
     * @var TranslationService
     */
    private $translationService;

    /**
     * Void __construct().
     *
     * @param ParameterBagInterface $params comment
     */
    public function __construct(ParameterBagInterface $params, TranslationService $translationService)
    {
        if (\file_exists($params->get('app_root').'/config/configuration.yaml')) {
            $this->configuration = Yaml::parseFile($params->get('app_root').'/config/configuration.yaml');
        }

        $this->translationService = $translationService;
    }

    /**
     * Return all config/configuration.yaml.
     */
    public function all(): array
    {
        return $this->configuration;
    }

    /**
     * Return tableau config/configuration.yaml.
     */
    public function get(string $key, string $option)
    {
        return $this->configuration[$key]['tabs'][$option]['value'];
    }

    /**
     * Si le multi langues est activer et que il a plus de langues que la langue par default,
     * le select multi langues est afficher en front.
     */
    public function multiLangues(): array
    {
        $langues = $this->translationService->filesActive();

        if ($this->get('site', 'multilangue') === 'true' && count($langues) > 1) {
            return $langues;
        } else {
            return $langues = [];
        }
    }
}
