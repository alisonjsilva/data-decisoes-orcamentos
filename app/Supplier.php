<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public function materials() {
        return $this->hasMany('App\Models\Material');
    }
}
