<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;

    public $timestamps    = false;
    protected $table      = "usuario";
    protected $guarded    = array('id', 'confirmar_senha');
    protected $primaryKey = 'id';
}
