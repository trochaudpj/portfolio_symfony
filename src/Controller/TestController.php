<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends BaseController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->template('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
