<?php

namespace App\Helpers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialHelpers
{
    /**
      * Handler Add Suppliers
      * @param string
      * @return int
      */
      public static function getOrAddSupplier($supplier_title) {

        // Supplier handler
        if(isset($supplier_title)) {   

            $supplier = DB::table('suppliers')
                ->select('id')
                ->where('title', $supplier_title)
                ->first();                

            if(empty($supplier)) {
                $supplier = DB::table('suppliers')
                ->insertGetId(
                    ['title' => $supplier_title]
                );

                return $supplier;
            }

            return $supplier->id;
        }

        return null;

      }
}