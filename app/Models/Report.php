<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Helpers\UniversalClass;

class Report extends Model
{
    const POSTS_PER_PAGE = 10;
    protected $table = 'report';

}

?>