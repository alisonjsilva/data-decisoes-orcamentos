<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function services() {
        return $this->belongsToMany(Service::class, 'services_materials');
    }
}
