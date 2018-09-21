<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
    protected $container;    

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }

    public function viewRender(Response $response, $templateUrl, $data = array())
    {
        return $this->container->view->render($response, $templateUrl, $data);
    }

    public function jsonRender(Response $response, $statusCode = 200, $data = array())
    {
        $response = $response->withHeader('Content-Type', 'application/json')->withStatus($statusCode);
        $response->getBody()->write(json_encode($data));
        //$response->withJson($data, $statusCode)->write(json_encode($data));

        return $response;
    }
}
