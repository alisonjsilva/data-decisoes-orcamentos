<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('proposal_id');
            $table->string('tab_id');
            $table->string('title');
            $table->string('high_ceiling')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('ceiling_floor')->nullable();
            $table->string('walls')->nullable();
            $table->string('linear')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabs');
    }
}
