<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table      = "empresa";
    protected $primaryKey = "id";
    protected $guarded    = array('id');
    public $timestamps    = false;
}
