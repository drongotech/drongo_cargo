<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnItemKgsToShipmentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipment_items', function (Blueprint $table) {
            $table->double('item_kgs')->nullable()->after('item_cpm');
            $table->integer('item_total')->default(1)->after('item_remarks');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment_items', function (Blueprint $table) {
            //
        });
    }
}
