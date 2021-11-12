<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends BaseController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function index(): Response
    {
        return $this->template('portfolio/index.html.twig', [
            'controller_name' => 'PortfolioController',
        ]);
    }
}
