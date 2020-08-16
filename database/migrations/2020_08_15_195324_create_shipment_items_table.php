<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('track_id');
            $table->string('item_name');
            $table->string('item_number');
            $table->double('item_quantity');
            $table->string('item_unit', 30);
            $table->double('item_cpm');
            $table->string('item_supplier');
            $table->string('item_remarks');
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
        Schema::dropIfExists('shipment_items');
    }
}
