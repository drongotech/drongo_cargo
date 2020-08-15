<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargoCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargo_companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_token');
            $table->string('company_name');
            $table->string('company_logo')->nullable();
            $table->string('company_phone');
            $table->string('company_email');
            $table->string('company_city');
            $table->integer('company_country');
            $table->string('company_location')->nullable();
            $table->string('company_pincode');
            $table->boolean('company_listed')->default(true);
            $table->integer('company_added_by');
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
        Schema::dropIfExists('cargo_companies');
    }
}
