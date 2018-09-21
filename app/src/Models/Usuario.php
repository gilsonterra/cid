<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public $timestamps    = false;
    protected $table      = "usuario";
    protected $guarded    = array('id', 'confirmar_senha');
    protected $primaryKey = 'id';
}
