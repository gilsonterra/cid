<?php

$app->add(new \Slim\Middleware\Minify());

if ($container->get('settings')['debug']) {
    $app->add(new RunTracy\Middlewares\TracyMiddleware($app));
}


