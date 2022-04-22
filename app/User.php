<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // specify fillables
    protected $fillable = ['name', 'email', 'is_admin', 'password'];

}
