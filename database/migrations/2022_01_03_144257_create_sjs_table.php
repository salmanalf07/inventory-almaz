<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sjs', function (Blueprint $table) {
            $table->id();
            $table->string('nosj');
            $table->bigInteger('cust_id');
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('invoice_id')->nullable();
            $table->bigInteger('car_id');
            $table->bigInteger('driver_id');
            $table->bigInteger('user_id');
            $table->date('date_sj')->nullable();
            $table->date('kembali_sj')->nullable();
            $table->date('kembali_rev')->nullable();
            $table->string('revisi')->nullable();
            $table->string('status')->default('Open');
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
        Schema::dropIfExists('sjs');
    }
}
