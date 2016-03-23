<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $table = 'user_devices';


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}