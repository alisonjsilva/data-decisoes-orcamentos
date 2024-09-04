<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceIdProposalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('proposal_services', 'service_id')) {
            Schema::table('proposal_services', function (Blueprint $table) {
                $table->integer('service_id')->nullable()->after('proposal_id');
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
        if (Schema::hasColumn('proposal_services', 'service_id')) {
            Schema::table('proposal_services', function (Blueprint $table) {
                $table->dropColumn('service_id');
            });
        }
    }
}
