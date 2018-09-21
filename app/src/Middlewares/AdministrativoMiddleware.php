<?php

namespace App\Middlewares;

use Slim\Container;
use App\Repositories\UsuarioRepository;

final class AdministrativoMiddleware
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function __invoke($request, $response, $next)
    {
        $session = $this->container->sessionHelper->get();
        $newResponse = $response;        
        if (empty($session['usuario_sessao']['admin']) || $session['usuario_sessao']['admin'] != 1) {
            throw new \Exception("Você não tem autorização para acessar essa tela.");
        } 
        else{
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }
}
