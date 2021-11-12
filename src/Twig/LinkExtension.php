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

use App\Service\LinkService;
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
class LinkExtension extends AbstractExtension
{
    /**
     * Variable $this->linkService.
     *
     * @var LinkService
     */
    private $linkService;

    /**
     * Void __construct().
     *
     * @param LinkService $linkService comment
     */
    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * Function getFunctions().
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('getScheme', [$this, 'getScheme']),
            new TwigFunction('getHttpHost', [$this, 'getHttpHost']),
            new TwigFunction('getBasePath', [$this, 'getBasePath']),
            new TwigFunction('getQueryString()', [$this, 'getQueryString()']),
            new TwigFunction('redirectWithQueryString', [$this, 'redirectWithQueryString']),
            new TwigFunction('getBaseServer', [$this, 'getBaseServer']),
            new TwigFunction('fullLink', [$this, 'fullLink']),
            new TwigFunction('fullLinkWithQueryString', [$this, 'fullLinkWithQueryString']),
        ];
    }

    public function getScheme(): string
    {
        return $this->linkService->getScheme();
    }

    public function getHttpHost(): string
    {
        return $this->linkService->getHttpHost();
    }

    public function getBasePath(): string
    {
        return $this->linkService->getBasePath();
    }

    public function getQueryString()
    {
        return $this->linkService->getQueryString();
    }

    public function redirectWithQueryString(string $path, array $arguments = [])
    {
        return $this->linkService->redirectWithQueryString($path, $arguments);
    }

    public function getBaseServer(): string
    {
        return $this->linkService->getBaseServer();
    }

    public function fullLink(string $path, array $arguments = []): string
    {
        return $this->linkService->fullLink($path, $arguments);
    }

    public function fullLinkWithQueryString(string $path, array $arguments = []): string
    {
        return $this->linkService->fullLinkWithQueryString($path, $arguments);
    }
}
