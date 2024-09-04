<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTabNameMaterialsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('materials_orders', 'tab_name')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->string('tab_name')->nullable()->after('supplier_title');
            });
        }
        if (!Schema::hasColumn('materials_orders', 'category_id')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->bigInteger('category_id')->nullable()->after('supplier_title');
            });
        }
        if (!Schema::hasColumn('materials_orders', 'category_title')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->string('category_title')->nullable()->after('supplier_title');
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
        if (Schema::hasColumn('materials_orders', 'tab_name')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->dropColumn('tab_name');
            });
        }
        if (Schema::hasColumn('materials_orders', 'category_id')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->dropColumn('category_id');
            });
        }
        if (Schema::hasColumn('materials_orders', 'category_title')) {
            Schema::table('materials_orders', function (Blueprint $table) {
                $table->dropColumn('category_title');
            });
        }
    }
}
