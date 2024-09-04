<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('created_user_id')->nullable()->after('proposal_id');
            $table->bigInteger('updated_user_id')->nullable()->after('created_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('orders', 'created_user_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('created_user_id');
            });
        }

        if (Schema::hasColumn('orders', 'updated_user_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('updated_user_id');
            });
        }
    }
}
