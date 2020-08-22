<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_status', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tracking_number');
            $table->integer('status');
            $table->string('loading_port')->nullable();
            $table->string('container_number')->nullable();
            $table->string('offloaded_port')->nullable();
            $table->string('delivered_by')->nullable();
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
        Schema::dropIfExists('tracking_status');
    }
}
