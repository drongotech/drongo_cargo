<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('company_staff', function (Blueprint $table) {
            $table->id();
            $table->string('staff_email')->unique();
            $table->string('staff_phone')->unique();
            $table->string('staff_password');
            $table->string('staff_name');
            $table->string('company_id');
            $table->string('company_token');
            $table->boolean('is_active')->default(false);
            $table->boolean('has_customer_write_perm')->default(false);
            $table->boolean('has_customer_delete_perm')->default(false);
            $table->boolean('has_supplier_read_perm')->default(false);
            $table->boolean('has_supplier_write_perm')->default(false);
            $table->boolean('has_supplier_delete_perm')->default(false);
            $table->boolean('has_shipment_read_perm')->default(false);
            $table->boolean('has_shipment_write_perm')->default(false);
            $table->boolean('has_shipment_delete_perm')->default(false);
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
        Schema::dropIfExists('company_staff');
    }
}
