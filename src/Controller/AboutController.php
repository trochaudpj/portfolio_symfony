<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends BaseController
{
    /**
     * @Route("/about", name="about")
     */
    public function index(): Response
    {
        return $this->template('about/index.html.twig', [
            'controller_name' => 'AboutController',
        ]);
    }
}
