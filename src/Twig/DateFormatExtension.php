<?php

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller\Admin
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

namespace App\Twig;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller\Admin
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * STARTER-KIT-SYMFONY
 * PHP version 7.
 *
 * @category App\Controller\Admin
 *
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 *
 * @see     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */
class DateFormatExtension extends AbstractExtension
{
    /**
     * Variable $this->translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Void __construct().
     *
     * @param TranslatorInterface $translator comment
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Appel de la methode $this->dateFormat.
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('date_format', [$this, 'dateFormat']),
        ];
    }

    /**
     * Retourne le format de la date traduite.
     *
     * @param object $date   date
     * @param string $format format de la date
     */
    public function dateFormat(object $date, string $format): string
    {
        return str_replace(
            [date_format($date, 'l'), date_format($date, 'F')],
            [$this->translator->trans(strtoupper(date_format($date, 'l'))), $this->translator->trans(strtoupper(date_format($date, 'F')))],
            date_format($date, $format)
        );
    }
}
