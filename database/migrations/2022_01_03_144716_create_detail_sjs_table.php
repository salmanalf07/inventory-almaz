<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_sjs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sj_id');
            $table->bigInteger('part_id');
            $table->bigInteger('qty');
            $table->string('qty_pack')->default('-');
            $table->string('type_pack')->default('-');
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
        Schema::dropIfExists('detail_sjs');
    }
}
