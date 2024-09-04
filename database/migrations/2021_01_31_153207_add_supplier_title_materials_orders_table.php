<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierTitleMaterialsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials_orders', function (Blueprint $table) {
            $table->text('supplier_title')->nullable()->after('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('materials_orders', 'supplier_title')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->dropColumn('supplier_title');
            });
        }
    }
}
