<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    protected $fillable = ['post_id', 'tag_name'];

}
