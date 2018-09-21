<?php

namespace App\Repositories;

use App\Models\Usuario;

use Illuminate\Pagination\AbstractPaginator as Paginator;

final class UsuarioRepository extends BaseRepository
{
    /**
     * @var Usuario
     */
    protected $model;

    /**
     * Constructor
     *
     * @param Local $model
     */
    public function __construct(Usuario $model)
    {
        $this->model = $model;
    }

    /**
     * Fetch All
     *
     * @param array $where
     * @param boolean $paginate
     * @param integer $page
     * @return void
     */
    public function fetchAll(array $where = array(), $paginate = false, $page = 1)
    {
        $query = $this->model->newQuery();
        $query->orderByRaw('UPPER(nome) ASC');

        // Where
        if (!empty($where['nome'])) {
            $query->whereRaw("UPPER(nome) LIKE ?", '%' . strtoupper($where['nome'] . '%'));
        }

        if (!empty($where['login'])) {
            $query->where('login', '=', $where['login']);
        }

        if (!empty($where['senha'])) {
            $query->where('senha', '=', $where['senha']);
        }

        $query->where('status', '=', ($where['status'] === '0') ? '0' : '1');

        if ($paginate) {
            $data = $this->paginate($query, $page);
        } else {
            $data = $query->get();
        }

        return $data;
    }

    /**
     * Find by Id
     *
     * @param int $id
     * @return void
     */
    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create
     *
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        $message = $this->createMessage('Usuario criado com sucesso.', 'Sucesso', BaseRepository::SUCCESS);

        try {            
            $this->model->create($data);
        } catch (\Exception $e) {
            $message = $this->createMessage('Erro ao criar um Usuario.' . $e->getMessage(), 'Erro', BaseRepository::ERROR);
        }

        return $message;
    }

    /**
     * Edit
     *
     * @param [type] $id
     * @param array $data
     * @return void
     */
    public function edit($id, array $data)
    {
        $message = $this->createMessage('Usuario alterado com sucesso.', 'Sucesso', BaseRepository::SUCCESS);

        try {
            $query = $this->findById($id);
            $query->fill($data)->save();
        } catch (\Exception $e) {
            $message = $this->createMessage('Erro ao alterar o Usuario.' . $e->getMessage(), 'Erro', BaseRepository::ERROR);
        }

        return $message;
    }
}
