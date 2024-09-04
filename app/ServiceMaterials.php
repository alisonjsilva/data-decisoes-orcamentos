<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceMaterials extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services_materials';

    // public function category () {
    //     return $this->hasOne(Category::class, 'id', 'category_id');
    // }
}
