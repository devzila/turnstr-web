<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['user_id', 'caption', 'media1_url','media2_url','media3_url','media4_url', 'media1_thumb_url', 'media2_thumb_url', 'media3_thumb_url', 'media4_thumb_url'];
}
