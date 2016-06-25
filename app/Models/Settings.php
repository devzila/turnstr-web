<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\UniversalClass;

class Settings extends Model
{
	public $timestamps = false;
    protected $table = 'settings';
	
}

?>