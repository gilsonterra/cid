<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table      = "cargo";
    protected $primaryKey = "id";
    protected $guarded    = array('id');
    public $timestamps    = false;
}
