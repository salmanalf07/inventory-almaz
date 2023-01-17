<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('address');
            $table->string('send_address');
            $table->string('phone')->nullable();
            $table->string('name_pic')->nullable();
            $table->string('phone_pic')->nullable();
            $table->double('distance')->nullable();
            $table->string('top')->nullable();
            $table->string('type_invoice')->nullable();
            $table->string('invoice_schedule')->nullable();
            $table->string('information')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('customers');
    }
}
