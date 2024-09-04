<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialsOrders extends Model
{
    protected $table = 'materials_orders';

    public function order() {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function proposalService() {
        return $this->hasOne(ProposalServices::class, 'id', 'service_id');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // public function supplier() {
    //     return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    // }
}
