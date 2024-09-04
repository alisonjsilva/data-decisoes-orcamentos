<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeneralIvaProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('proposals', 'iva_id')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->bigInteger('iva_id')->nullable()->after('email');
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
        if (Schema::hasColumn('proposals', 'iva_id')) {
            Schema::table('proposals', function (Blueprint $table) {
                $table->dropColumn('iva_id');
            });
        }
    }
}
