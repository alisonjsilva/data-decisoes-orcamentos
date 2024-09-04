<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description', 500)->nullable();
            $table->string('unit')->nullable();
            $table->decimal('quantity');
            $table->decimal('price');
            $table->integer('category_id')->nullable();
            $table->integer('ord')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('tabid')->nullable();
            $table->string('tab_name')->nullable();
            $table->integer('proposal_id');
            $table->integer('service_id')->nullable();
            $table->boolean('vg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proposal_services');
    }
}
