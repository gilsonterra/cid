<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PessoaSAP extends Model
{
    protected $table      = "sap.tbl_pessoa";
    protected $primaryKey = "matricula";
    protected $guarded    = array('matricula');
    public $timestamps    = false;
}
