<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $table      = "pessoa";
    protected $primaryKey = "id";
    protected $guarded    = array('id', 'veiculos');
    public $timestamps    = false;

    public function empresa(){
        return $this->hasOne('App\Models\Empresa', 'id', 'empresa_id');
    }

    public function departamento(){
        return $this->hasOne('App\Models\Departamento', 'id', 'departamento_id');
    }

    public function cargo(){
        return $this->hasOne('App\Models\Cargo', 'id', 'cargo_id');
    }

    public function veiculos(){
        return $this->belongsToMany('App\Models\Veiculo', 'pessoa_x_veiculo', 'pessoa_id', 'veiculo_id');
    }
}
