<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalMaterialsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials_orders', function (Blueprint $table) {
            $table->decimal('total')->nullable()->after('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('materials_orders', 'total')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->dropColumn('total');
            });
        }
    }
}
