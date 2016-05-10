<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passwordreset extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_resets';
    public $timestamps = false;
}
