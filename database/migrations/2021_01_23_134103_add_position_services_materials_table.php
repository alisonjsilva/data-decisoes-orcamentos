<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionServicesMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_materials', function (Blueprint $table) {
            $table->integer('ord')->nullable()->after('service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('services_materials', 'ord')) {
            Schema::table('services_materials', function (Blueprint $table) {
                $table->dropColumn('ord');
            });
        }
    }
}
