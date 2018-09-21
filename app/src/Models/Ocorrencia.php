<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
    protected $table      = "ocorrencia";
    protected $primaryKey = "id";
    protected $guarded    = array('id');
    public $timestamps    = false;
}
