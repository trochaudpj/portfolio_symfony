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
class SocieteService
{
    /**
     * Variable $this->societe.
     *
     * @var array
     */
    private $societe = [];

    /**
     * Void __construct().
     *
     * @param ParameterBagInterface $params comment
     */
    public function __construct(ParameterBagInterface $params)
    {
        if (\file_exists($params->get('app_root').'/config/societe.yaml')) {
            $this->societe = Yaml::parseFile($params->get('app_root').'/config/societe.yaml');
        }
    }

    /**
     * Return all config/societe.yaml.
     */
    public function all(): array
    {
        return $this->societe;
    }

    /**
     * Return value config/societe.yaml.
     */
    public function getValue(string $key, string $option)
    {
        return $this->societe[$key]['tabs'][$option]['value'];
    }

    /**
     * Return key config/societe.yaml.
     */
    public function get(string $key)
    {
        return $this->societe[$key];
    }
}
