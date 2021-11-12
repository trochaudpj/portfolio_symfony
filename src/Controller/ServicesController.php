<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends BaseController
{
    /**
     * @Route("/services", name="services")
     */
    public function index(): Response
    {
        return $this->template('services/index.html.twig', [
            'controller_name' => 'ServicesController', 

        ]);
    }
}
