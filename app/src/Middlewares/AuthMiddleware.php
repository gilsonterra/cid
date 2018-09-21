<?php

namespace App\Middlewares;

use Slim\Container;
use App\Repositories\UsuarioRepository;

final class AuthMiddleware
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __invoke($request, $response, $next)
    {
        $session = $this->container->sessionHelper->get();
        
        if (empty($session['usuario_sessao'])) {            
            if ($request->isXhr()) {
                //$newResponse = $response->withStatus(401);                
                header("HTTP/1.1 401 Unauthorized");                
                exit;
            } else {
                header('Location: ' . $this->container->router->pathFor('login'), true, 401);
            }
        } else {            
            $newResponse = $next($request, $response);
        }
        
        return $newResponse;
    }
}
