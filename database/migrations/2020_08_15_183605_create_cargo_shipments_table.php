<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargoShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tracking_number')->unique();
            $table->string('customer_name');
            $table->string('city_of_origin');
            $table->string('country_of_origin');
            $table->string('destination_city');
            $table->string('destination_country');
            $table->string('company_token');
            $table->bigInteger('company_id');
            $table->integer('track_status')->default(10);
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
        Schema::dropIfExists('cargo_shipments');
    }
}
