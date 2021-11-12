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

namespace App\Controller\Admin;

/*
 * STARTER-KIT-SYMFONY
 * PHP version 7
 *
 * @category App\Controller\Admin
 * @package  AdminStatistiquesController.php
 * @author   FERRERO Franck <ferrerofranck@plateformweb.com>
 * @license  http://opensource.org/licenses/gpl-license.php MIT License
 * @link     https://github.com/madbrain67/STARTER-KIT-SYMFONY
 */

use App\Controller\BaseController;
use App\Service\Admin\ConfigurationService;
use App\Service\LinkService;
use App\Service\Token\TokenGenerator;
use App\Traits\Folder;
use App\Traits\Timezone;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminConfigurationController extends BaseController
{
    use Timezone;
    use Folder;

    /**
     * Variable $this->configurationService.
     *
     * @var ConfigurationService
     */
    private $configurationService;

    /**
     * Variable$this->session.
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * Variable $this->linkService.
     *
     * @var LinkService
     */
    private $linkService;

    /**
     * Void __construct().
     *
     * @param ConfigurationService $configurationService comment
     * @param SessionInterface     $session              comment
     * @param LinkService          $linkService          comment
     */
    public function __construct(ConfigurationService $configurationService, SessionInterface $session, LinkService $linkService)
    {
        $this->configurationService = $configurationService;
        $this->session = $session;
        $this->linkService = $linkService;
    }

    /**
     * Public function index().
     *
     * @Route("/admin/configuration", name="admin_configuration")
     */
    public function index(): Response
    {
        $token = new TokenGenerator();
        $token->setSession();

        return $this->render('admin/configuration/index.html.twig', [
            'controller_name' => 'AdminConfigurationController',
            'token' => $token->getToken(),
            'config' => $this->configurationService->get(),
            'timezones' => $this->getTimezone(),
            'templates' => $this->scanTemplates($this->getParameter('app_root').'/templates'),
            'redirect' => $this->linkService->redirectWithQueryString('admin_configuration_update'),
        ]);
    }

    /**
     * Public function update().
     *
     * @param Request $request comment
     *
     * @Route("/admin/configuration/update", name="admin_configuration_update", methods={"POST"})
     */
    public function update(Request $request): RedirectResponse
    {
        if ($request->request->get('token') && $this->session->get('token') === $request->request->get('token')) {
            $request->request->remove('token');
            $update = $this->configurationService->update($request->request->all());
            $this->addFlash($update['code'], $update['message']);
        }

        return new RedirectResponse($this->linkService->redirectWithQueryString('admin_configuration'));
    }
}
