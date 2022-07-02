<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packing_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id');
            $table->string('label_pack');
            $table->bigInteger('qty_out');
            $table->bigInteger('total_fg');
            $table->bigInteger('tota_ng');
            $table->string('type_ng');
            $table->bigInteger('total_pack');
            $table->string('operator');
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
        Schema::dropIfExists('packing_transactions');
    }
}
