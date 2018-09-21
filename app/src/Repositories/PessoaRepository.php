<?php

namespace App\Repositories;

use App\Models\Pessoa;
use App\Models\Veiculo;
use Illuminate\Database\Capsule\Manager as DB;

final class PessoaRepository extends BaseRepository
{
    /**
     * @var Pessoa
     */
    protected $model;

    /**
     * @var Veiculo
     */
    protected $modelVeiculo;

    /**
     * Constructor
     *
     * @param Pessoa $model
     */
    public function __construct(Pessoa $model, Veiculo $modelVeiculo)
    {
        $this->model = $model;
        $this->modelVeiculo = $modelVeiculo;
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
        $query->with(['empresa', 'departamento', 'cargo', 'veiculos'])->orderBy('nome', 'asc');

        // Wheres
        if (!empty($where['nome'])) {
            $query->where('LOWER(nome)', 'LIKE', "%" . strtolower($where['nome']). "%");
        }

        if (!empty($where['empresa'])) {
            $query->whereHas('empresa', function ($q) use ($where) {
                $q->whereRaw("LOWER(descricao) LIKE '%" . strtolower($where['empresa']) . "%'");
            });
        }

        if (!empty($where['departamento'])) {
            $query->whereHas('departamento', function ($q) use ($where) {
                $q->whereRaw("LOWER(descricao) LIKE '%" . strtolower($where['departamento']) . "%'");
            });
        }

        if (!empty($where['cargo'])) {
            $query->whereHas('cargo', function ($q) use ($where) {
                $q->whereRaw("LOWER(descricao) LIKE '%" . strtolower($where['cargo']) . "%'");
            });
        }

        if (!empty($where['matricula'])) {
            $query->where('matricula', '=', $where['matricula']);
        }

        if (!empty($where['placa'])) {
            $query->whereHas('veiculos', function ($q) use ($where) {
                $q->where("placa", '=', $wheres['placa']);
            });
        }

        if (!empty($where['identificador'])) {
            $query->whereHas('veiculos', function ($q) use ($where) {
                $q->where("identificador", '=', $where['identificador']);
            });
        }

        if (!empty($where['modelo'])) {
            $query->whereHas('veiculos', function ($q) use ($where) {
                $q->whereRaw("LOWER(modelo) LIKE '%" . strtolower($where['modelo']) . "%'");
            });
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
        return $this->model->with(['empresa', 'departamento', 'cargo', 'veiculos'])->findOrFail($id);
    }

    
    /**
     * Create
     *
     * @param array $data
     * @return void
     */
    public function create(array $data)
    {
        $pdo = DB::getPdo();
        $message = $this->createMessage('Pessoa criado com sucesso.', 'Sucesso', BaseRepository::SUCCESS);

        try {
            $pdo->beginTransaction();
            $veiculosInstance = $this->getVeiculosInstances($data['veiculos']);            
    
            $pessoa = $this->model->create($data);
            $pessoa->veiculos()->saveMany($veiculosInstance);
            
            $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();
            $message = $this->createMessage('Erro ao criar um Pessoa.' . $e->getMessage(), 'Erro', BaseRepository::ERROR);
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
        $pdo = DB::getPdo();
        $message = $this->createMessage('Pessoa alterado com sucesso.', 'Sucesso', BaseRepository::SUCCESS);

        try {
            $pdo->beginTransaction();

            $pessoa = $this->model->findOrFail($id);
            $pessoa->fill($data)->save();        

            $veiculosInstance = $this->getVeiculosInstances($data['veiculos']);   
            $pessoa->veiculos()->detach();
            $pessoa->veiculos()->saveMany($veiculosInstance);

            $pdo->commit();
        } catch (\Exception $e) {
            $pdo->rollBack();
            $message = $this->createMessage('Erro ao alterar o Pessoa.' . $e->getMessage(), 'Erro', BaseRepository::ERROR);
        }

        return $message;
    }

    /**
     * get Locais
     *
     * @param array $locais
     * @return void
     */
    protected function getVeiculosInstances($veiculos)
    {
        $veiculosInstance = [];
        foreach ($veiculos as $veiculo) {                   
            array_push($veiculosInstance, $this->modelVeiculo->firstOrNew($veiculo));
        }

        return $veiculosInstance;
    }


    public function buscarEmpresa()
    {
        $empresaModel = new \App\Models\Empresa();
        return $empresaModel->all();
    }

    public function buscarDepartamento()
    {
        $empresaModel = new \App\Models\Departamento();
        return $empresaModel->all();
    }

    public function buscarCargo()
    {
        $empresaModel = new \App\Models\Cargo();
        return $empresaModel->all();
    }
}
