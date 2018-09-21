<?php

use App\Middlewares\AuthMiddleware;
use App\Middlewares\AdministrativoMiddleware;

// $app->options('/{routes:.+}', function ($request, $response, $args) {
//     return $response;
// });

$app->post('/console', 'RunTracy\Controllers\RunTracyConsole:index');

$app->get('/', function () {    
    header('Location: ' . '/login/entrar');exit;
});

$app->group('/login', function () {
    $this->get('/entrar', 'App\Controllers\LoginController:loginView')->setName('login');
    $this->post('/login[/]', 'App\Controllers\LoginController:login');
    $this->get('/logout[/]', 'App\Controllers\LoginController:logout');
});

$app->group('/usuario', function () {
    $this->get('/listar[/]', 'App\Controllers\UsuarioController:listView');
    $this->get('/criar', 'App\Controllers\UsuarioController:createView');
    $this->get('/editar/{id}', 'App\Controllers\UsuarioController:editView');
    $this->post('/persistir/[{id}]', 'App\Controllers\UsuarioController:store');
    $this->post('/buscar[/]', 'App\Controllers\UsuarioController:fetchAll');
})
->add(new AuthMiddleware($app->getContainer()));

$app->group('/pessoa', function () {
    $this->get('/listar[/]', 'App\Controllers\PessoaController:listView');
    $this->get('/criar', 'App\Controllers\PessoaController:createView');
    $this->get('/editar/{id}', 'App\Controllers\PessoaController:editView');
    $this->post('/persistir/[{id}]', 'App\Controllers\PessoaController:store');
    $this->post('/buscar[/]', 'App\Controllers\PessoaController:fetchAll');
    $this->get('/buscar-placa/{placa}', 'App\Controllers\PessoaController:buscaPlaca');
    $this->get('/buscar-empresas[/]', 'App\Controllers\PessoaController:buscaEmpresa');
    $this->get('/buscar-cargos[/]', 'App\Controllers\PessoaController:buscaCargo');
    $this->get('/buscar-departamentos[/]', 'App\Controllers\PessoaController:buscaDepartamento');
})
->add(new AuthMiddleware($app->getContainer()));

$app->get('/info', function () {
    phpinfo();
});
