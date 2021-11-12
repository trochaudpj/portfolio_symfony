<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class BaseController extends AbstractController
{
    protected function manager()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function template(string $view, array $parameters = [], Response $response = null): Response
    {
        $template = 'default';

        if (\file_exists($this->getParameter('app_root').'/config/configuration.yaml')) {
            $configuration = Yaml::parseFile($this->getParameter('app_root').'/config/configuration.yaml');
            if (isset($configuration['site']['tabs']['template']['value']) && !empty($configuration['site']['tabs']['template']['value'])) {
                $template = $configuration['site']['tabs']['template']['value'];
            }
        }

        $parameters['template'] = $template;

        return $this->render($template.'/'.$view, $parameters, $response);
    }
}
