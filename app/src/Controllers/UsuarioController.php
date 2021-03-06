<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Container as Container;
use App\Repositories\UsuarioRepository;
use App\Validators\UsuarioValidator;

final class UsuarioController extends BaseController
{
    protected $repository;
    protected $validator;

    public function __construct(Container $container, UsuarioRepository $repository, UsuarioValidator $validator)
    {
        parent::__construct($container);
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function listView(Request $request, Response $response, $args)
    {
        $data = $request->getParams();
        $data['grid'] = $this->repository->fetchAll($data, true, $data['page'])->toArray();
        return $this->viewRender($response, 'usuario/list.html', $data);
    }

    public function createView(Request $request, Response $response, $args)
    {
        return $this->viewRender($response, 'usuario/form.html');
    }

    public function editView(Request $request, Response $response, $args)
    {
        $data['dados'] = $this->repository->findById($args['id'])->toArray();
        return $this->viewRender($response, 'usuario/form.html', $data);
    }

    public function store(Request $request, Response $response, $args)
    {
        $data['dados'] = $request->getParams();
        $data['errors'] = $this->validator->valid($data['dados']);

        if (empty($data['errors'])) {
            if (empty($args['id'])) {
                $data['message'] = $this->repository->create($data['dados']);
            } else {
                $data['message'] = $this->repository->edit($args['id'], $data['dados']);
            }
        }

        return $this->jsonRender($response, 200, $data);
    }

    public function fetchAll(Request $request, Response $response, $args)
    {
        $data = $request->getParams();
        $data = $this->repository->fetchAll($data, $data['paginate'], $data['page'])->toArray();
        return $this->jsonRender($response, 200, $data);
    }
}
