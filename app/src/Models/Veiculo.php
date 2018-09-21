<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $table      = "veiculo";
    protected $primaryKey = "id";
    protected $guarded    = array('id');
    public $timestamps    = false;


    public function ocorrencias(){
        return $this->hasToMany('App\Models\Ocorrencia');
    }
}
