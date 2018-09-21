<?php

/**
 * PAGE NOT FOUND (404)
 */
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        if ($request->isXhr()) {
            return $c['response']->withStatus(404)->withHeader('Content-Type', 'text/json')->write(json_encode('Página não encontrada!'));
        } else {
            return $c['view']->render($response, '400.html', []);
        }
    };
};
/**
 * PAGE NOT ALLOWED (405)
 */
$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {        
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write('O metodo deve ser: ' . implode(', ', $methods));
    };
};

/**
 * PAGE ERROR (500)
 */
$container['errorHandler'] = function ($c) {
    return function (Slim\Http\Request $request, $response, $exception) use ($c) {        
        if ($request->isXhr()) {
            $dados = [
                'title' => 'Erro',
                'html'  => 'Ocorreu um erro inesperado. <br /> <code>' . $exception->getMessage() . '</code>',
                'type'  => 'error'
            ];
            
            return $c['response']->withStatus(500)->withHeader('Content-Type', 'text/json')->write(json_encode($dados));
        } else {            
            return $c['view']->render($response, '500.html', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    };
};

$container['phpErrorHandler'] = function ($c) {        
    return function (Slim\Http\Request $request, $response, $exception) use ($c) {
        if ($request->isXhr()) {
            $dados = [
                'title' => 'Erro',
                'html'  => 'PHP FATAL ERROR: <br /> <code>' . $exception->getMessage() . '</code>',
                'type'  => 'error'
            ];
            
            return $c['response']->withStatus(500)->withHeader('Content-Type', 'text/json')->write(json_encode($dados));
        } else {
            //var_dump($exception);exit;
            return $c['view']->render($response, '500.html', [
                'message' => 'PHP FATAL ERROR: ' . $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
        }
    };
};
