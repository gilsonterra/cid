<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table      = "departamento";
    protected $primaryKey = "id";
    protected $guarded    = array('id');
    public $timestamps    = false;
}
