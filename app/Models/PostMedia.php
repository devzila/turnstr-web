<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{
    public function posts()
    {
        return $this->belongsTo('App\Models\Posts','id','post_id');
    }
}
