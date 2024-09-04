<?php

namespace App;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function status_list() {
        return DB::table('orders_status')->get();
    }

    public function materials () {
        return $this->hasMany(MaterialsOrders::class);
    }
}
