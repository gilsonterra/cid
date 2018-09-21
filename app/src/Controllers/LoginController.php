<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container as Container;
use App\Repositories\UsuarioRepository;
use App\Validators\LoginValidator;

final class LoginController extends BaseController
{    
    public function __construct(Container $container, UsuarioRepository $repository, LoginValidator $validator)
    {
        parent::__construct($container);
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function loginView(Request $request, Response $response, $args)
    {
        $data['not_menu'] = true;
        return $this->viewRender($response, 'login.html', $data);
    }

    public function login(Request $request, Response $response, $args)
    {        
        $data = $request->getParams();
        $data['errors'] = $this->validator->valid($data);

        if (empty($data['errors'])) {
            $profissional = $this->repository->fetchAll($data)->first();

            if(empty($profissional)){
                $data['message'] = $this->repository->createMessage('Login ou senha inválidos!', 'Alerta', 'warning');
            }
            else{
                $sessao['usuario_sessao'] = $profissional->toArray();
                $data['message'] = $this->repository->createMessage('Autenticado com sucesso', 'Sucess', 'success', $sessao);
                $this->container->sessionHelper->set($sessao);
            }            
        }

        return $this->jsonRender($response, 200, $data);
    }

    public function logout(Request $request, Response $response, $args)
    {                        
        $this->container->sessionHelper->destroy();
        header('Location: ' . $this->container->router->pathFor('login'));                           
    }
}
