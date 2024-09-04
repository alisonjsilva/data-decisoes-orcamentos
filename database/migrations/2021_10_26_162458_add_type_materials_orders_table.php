<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeMaterialsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('materials_orders', 'type_id')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->bigInteger('type_id')->nullable()->after('price');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('materials_orders', 'type_id')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->dropColumn('type_id');
            });
        }
    }
}
