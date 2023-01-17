<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockWipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_wips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('partin_id');
            $table->bigInteger('part_id');
            $table->bigInteger('qty');
            $table->bigInteger('qty_out');
            $table->string('type');
            $table->bigInteger('total_price');
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
        Schema::dropIfExists('stock_wips');
    }
}
