<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    public $timestamps = false;
    protected $table = 'children';
    protected $hidden = [];
    protected $casts = ['age' => 'integer', 'toy_id' => 'integer'];

    public function toy(){
        return $this->belongsTo('App\Toy');
    }
}
