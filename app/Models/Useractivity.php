<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Useractivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'user_activity';
    protected $fillable = [
        'user_id', 'follower_id', 'post_id', 'liked_id', 'activity', 'status'
    ];
}
