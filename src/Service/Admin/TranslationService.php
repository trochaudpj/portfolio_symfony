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
use Symfony\Component\Intl\Languages;
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
class TranslationService
{
    /**
     * Variable $this->params.
     *
     * @var ParameterBagInterface
     */
    private $params;

    /**
     * Variable $this->translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Void __construct().
     *
     * @param ParameterBagInterface $params comment
     */
    public function __construct(ParameterBagInterface $params, TranslatorInterface $translator)
    {
        $this->params = $params;
        $this->translator = $translator;
    }

    /**
     * Retourn la la,gue associé a son code.
     *
     * @param string $code comment
     */
    public function getLanguage(string $code): string
    {
        return ucfirst(Languages::getName($code, $code));
    }

    /**
     * Retourne un tableau des langues avec leurs codes.
     *
     * @return void
     */
    public function getFullLanguages(): array
    {
        $locales = [];
        foreach (Languages::getLanguageCodes() as $code) {
            $locales[$code] = ucfirst(Languages::getName($code, $code));
        }

        return $locales;
    }

    public function locale(): string
    {
        return $this->params->get('locale');
    }

    /**
     * Retourne un tableau des traduction pour une langue choisie.
     *
     * @param string $locale fr,de,it....
     */
    public function getFile(string $locale): array
    {
        $translations = [];

        if (\file_exists($this->params->get('app_root').'/translations/messages.'.$locale.'.yaml')) {
            $translations = Yaml::parseFile($this->params->get('app_root').'/translations/messages.'.$locale.'.yaml');
        }

        return $translations;
    }

    /**
     * Check si un fichier tmp de traduction existe pour la langue choisie.
     *
     * @param string $locale fr,de,it....
     */
    public function CheckTmpFile(string $locale): bool
    {
        if (\file_exists($this->params->get('app_root').'/translations/tmp/messages.'.$locale.'_tmp.yaml')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retourne un key de traduction avec sa valeur.
     *
     * @param string $locale fr,en,de .....
     * @param string $key    key de traduction
     */
    public function getKey(string $locale, string $key): array
    {
        $translations = $this->getFile($locale);
        if (\array_key_exists($key, $translations)) {
            return [
                'key' => $key,
                'value' => $translations[$key],
            ];
        } else {
            return [];
        }
    }

    /**
     * Update le fichier de traduction pour une langue choisie.
     *
     * @param string $locale fr,en,de .....
     * @param string $key    key de traduction
     * @param string $value  text de traduction
     */
    public function updateFile(string $locale, string $key, string $value): array
    {
        $translations = $this->getFile($locale);
        if (!empty($translations)) {
            // Copie du fichier
            $filename = $this->params->get('app_root').'/translations/messages.'.$locale.'.yaml';
            $oldFilename = $this->params->get('app_root').'/translations/old/messages.'.$locale.'_old.yaml';
            file_put_contents($oldFilename, file_get_contents($filename));

            // Mise a jour du fichier
            $translations[$key] = str_replace(['<p>', '</p>'], ['', ''], $value);
            file_put_contents($filename, Yaml::dump($translations));
            exec('rm -R var/cache');

            return [
               'code' => 'success',
               'message' => $this->translator->trans('KEY-TRANSLATION-UPDATE', ['%key%' => $key]),
            ];
        } else {
            return [
                'code' => 'error',
                'message' => $this->translator->trans('KEY-TRANSLATION-NO-UPDATE', ['%key%' => $key]),
            ];
        }
    }

    /**
     * Update le fichier de traduction pour une langue choisie.
     *
     * @param string $locale fr,en,de .....
     * @param string $key    key de traduction
     * @param string $value  text de traduction
     */
    public function updateTmpFile(string $locale, string $key, string $value): array
    {
        $filename = $this->params->get('app_root').'/translations/tmp/messages.'.$locale.'_tmp.yaml';
        $translations = Yaml::parseFile($filename);
        // Mise a jour du fichier
        $translations[$key] = str_replace(['<p>', '</p>'], ['', ''], $value);
        file_put_contents($filename, Yaml::dump($translations));
        exec('rm -R var/cache');

        return [
            'code' => 'success',
            'message' => $this->translator->trans('KEY-TRANSLATION-UPDATE', ['%key%' => $key]),
        ];
    }

    /**
     * Créer un nouveau fichier de traduction.
     *
     * @param string $locale comment
     * @param array  $datas  comment
     */
    public function newFile(string $locale, array $datas): array
    {
        $filename = $this->params->get('app_root').'/translations/messages.'.$locale.'.yaml';
        file_put_contents($filename, Yaml::dump($datas));
        exec('rm -R var/cache');

        return [
            'code' => 'success',
            'message' => $this->translator->trans('TRANSLATION-FILE-CREATE', ['%langue%' => $locale]),
         ];
    }

    /**
     * Retourne un tableau des fichiers de traduction actifs.
     */
    public function filesActive(): array
    {
        $files = [];

        $filename = scandir($this->params->get('app_root').'/translations');
        $extensions = ['yaml'];
        for ($i = 0; $i < count($filename); ++$i) {
            $extension = pathinfo($filename[$i], PATHINFO_EXTENSION);
            if (in_array($extension, $extensions)) {
                //if (in_array($extension, $extensions) && substr($filename[$i], -9, -5) !== '_old' && substr($filename[$i], -9, -5) !== '_tmp') {
                $code = substr($filename[$i], -7, -5);
                $langue = $this->getLanguage($code);
                $files[$code] = $langue;
            }
        }

        return $files;
    }

    /**
     * Créer le fichier de traduiction temporaire si il existe pas.
     *
     * @param string $default comment
     * @param string $nouveau comment
     *
     * @return void
     */
    public function createTmpTranslation(string $default, string $nouveau)
    {
        $default = $this->params->get('app_root').'/translations/messages.'.$default.'.yaml';
        $nouveau = $this->params->get('app_root').'/translations/tmp/messages.'.$nouveau.'_tmp.yaml';

        $tmp = [];
        foreach (Yaml::parseFile($default) as $key => $value) {
            $tmp[$key] = '';
        }
        if (!\file_exists($nouveau)) {
            file_put_contents($nouveau, Yaml::dump($tmp));
        }
    }

    /**
     * Merge le tableau par default avec le tableau tmp de traduction.
     *
     * @param string $default comment
     * @param string $nouveau comment
     */
    public function setMerge(string $default, string $nouveau): array
    {
        $default = $this->params->get('app_root').'/translations/messages.'.$default.'.yaml';
        $nouveau = $this->params->get('app_root').'/translations/tmp/messages.'.$nouveau.'_tmp.yaml';

        $tmp = [];
        foreach (Yaml::parseFile($default) as $key => $value) {
            $tmp[$key] = [
                'value' => '',
                'help' => $value,
            ];
        }

        foreach (Yaml::parseFile($nouveau) as $key => $value) {
            $tmp[$key]['value'] = $value;
        }

        return $tmp;
    }

    /**
     * Retourne un tableau pour la clé de traduction tmp a traduire.
     *
     * @param string $default comment
     * @param string $nouveau comment
     * @param string $key     comment
     */
    public function getKeyMerge(string $default, string $nouveau, string $key): array
    {
        $tmp = $this->setMerge($default, $nouveau);

        return [
            'key' => $key,
            'value' => $tmp[$key]['value'],
            'help' => $tmp[$key]['help'],
        ];
    }

    /**
     * Active un fichier de langue.
     *
     * @param string $locale comment
     */
    public function enable(string $locale): array
    {
        $rename = rename(
            $this->params->get('app_root').'/translations/tmp/messages.'.$locale.'_tmp.yaml',
            $this->params->get('app_root').'/translations/messages.'.$locale.'.yaml'
        );

        if ($rename === true) {
            return [
                'code' => 'success',
                'message' => $this->translator->trans('TRANSLATION-ENABLE', ['%langue%' => $this->getLanguage($locale)]),
             ];
        } else {
            return [
                'code' => 'error',
                'message' => $this->translator->trans('TRANSLATION-NO-ENABLE', ['%langue%' => $this->getLanguage($locale)]),
             ];
        }
    }

    /**
     * Désactive un fichier de langue.
     *
     * @param string $locale comment
     */
    public function disable(string $locale): array
    {
        $rename = rename(
            $this->params->get('app_root').'/translations/messages.'.$locale.'.yaml',
            $this->params->get('app_root').'/translations/tmp/messages.'.$locale.'_tmp.yaml'
        );

        if ($rename === true) {
            return [
                'code' => 'success',
                'message' => $this->translator->trans('TRANSLATION-DISABLE', ['%langue%' => $this->getLanguage($locale)]),
             ];
        } else {
            return [
                'code' => 'error',
                'message' => $this->translator->trans('TRANSLATION-NO-DISABLE', ['%langue%' => $this->getLanguage($locale)]),
             ];
        }
    }
}
