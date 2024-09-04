<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials_orders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description', 500)->nullable();
            $table->string('unit')->nullable();
            $table->string('quantity')->nullable();
            $table->string('final_quantity')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('final_price')->nullable();
            $table->decimal('final_subtotal')->nullable();
            $table->decimal('subtotal')->nullable();
            $table->string('notes')->nullable();
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('service_id')->nullable();
            $table->bigInteger('status')->nullable();
            $table->dateTime('delivery_date')->nullable();
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
        Schema::dropIfExists('materials_orders');
    }
}
