<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends BaseController
{
    /**
     * @Route("/contact", name="contact")   
     */
    public function index(): Response
    {
        return $this->template('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
