<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->date('date_transaction');
            $table->string('no_transaction');
            $table->string('no_rak');
            $table->bigInteger('total_sa');
            $table->bigInteger('grand_totals');
            $table->time('time_start')->nullable();
            $table->time('time_end')->nullable();
            $table->string('operator');
            $table->string('status')->default('OPEN');
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
        Schema::dropIfExists('transactions');
    }
}
