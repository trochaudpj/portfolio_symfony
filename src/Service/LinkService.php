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

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
class LinkService
{
    /**
     * Variable $this->requestStack.
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Variable $this->urlGenerator.
     *
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Void __construct().
     *
     * @param RequestStack          $requestStack comment
     * @param UrlGeneratorInterface $urlGenerator comment
     */
    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $urlGenerator)
    {
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
    }

    public function getScheme(): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request !== null ? $request->getScheme() : '';
    }

    public function getHttpHost(): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request !== null ? $request->getHttpHost() : '';
    }

    public function getBasePath(): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request !== null ? $request->getBasePath() : '';
    }

    public function getQueryString()
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request !== null ? $request->getQueryString() : '';
    }

    public function redirectWithQueryString(string $path, array $arguments = [])
    {
        $request = $this->requestStack->getCurrentRequest();

        return $this->urlGenerator->generate($path, $arguments).'?'.$request->getQueryString();
    }

    public function getBaseServer(): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request->getScheme().'://'.$request->getHttpHost().$request->getBasePath();
    }

    public function fullLink(string $path, array $arguments = []): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request->getScheme().'://'.$request->getHttpHost().$request->getBasePath().$this->urlGenerator->generate($path, $arguments);
    }

    public function fullLinkWithQueryString(string $path, array $arguments = []): string
    {
        $request = $this->requestStack->getCurrentRequest();

        return $request->getScheme()
               .'://'.$request->getHttpHost()
               .$request->getBasePath()
               .$this->urlGenerator->generate($path, $arguments)
               .'?'.$request->getQueryString();
    }
}
