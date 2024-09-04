<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitFieldsMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->decimal('unit_price')->nullable()->after('supplier_id');
            $table->string('unit_value')->nullable()->after('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('materials', 'unit_price')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->dropColumn('unit_price');
            });
        }

        if (Schema::hasColumn('materials', 'unit_value')) {
            Schema::table('materials', function (Blueprint $table) {
                $table->dropColumn('unit_value');
            });
        }
    }
}
