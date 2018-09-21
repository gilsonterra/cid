<?php

$container['App\Controllers\LoginController'] = function ($container) {
    $model = new App\Models\Usuario();    
    $validator = new App\Validators\LoginValidator();
    $repository = new App\Repositories\UsuarioRepository($model);    
    return new App\Controllers\LoginController($container, $repository, $validator);
};

$container['App\Controllers\UsuarioController'] = function ($container) {    
    $model = new App\Models\Usuario();
    $repository = new App\Repositories\UsuarioRepository($model);    
    $validator = new App\Validators\UsuarioValidator();

    return new App\Controllers\UsuarioController($container, $repository, $validator);
};

$container['App\Controllers\PessoaController'] = function ($container) {    
    $model = new App\Models\Pessoa();
    $modelVeiculo = new App\Models\Veiculo();
    $repository = new App\Repositories\PessoaRepository($model, $modelVeiculo);    
    $validator = new App\Validators\PessoaValidator();

    return new App\Controllers\PessoaController($container, $repository, $validator);
};