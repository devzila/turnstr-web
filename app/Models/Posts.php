<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['user_id','media1_url','media2_url','media3_url','media4_url']; 
}
