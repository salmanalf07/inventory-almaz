<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cust_id');
            $table->date('date_inv')->nullable();
            $table->string('no_invoice');
            $table->string('no_faktur')->nullable();
            $table->date('tukar_faktur')->nullable();
            $table->bigInteger('order_id');
            $table->string('detail_order');
            $table->bigInteger('harga_jual');
            $table->bigInteger('ppn');
            $table->bigInteger('pph');
            $table->bigInteger('total_harga');
            $table->date('jatuh_tempo')->nullable();
            $table->date('tanggal_bayar')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
