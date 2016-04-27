<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toy extends Model
{
    protected $hidden = ['deleted_at'];
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}
