<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->date('date_production');
            $table->time('hour_actual_st');
            $table->time('hour_actual_en');
            $table->string('output_act');
            $table->string('hanger_rusak')->nullable();
            $table->string('tidak_racking')->nullable();
            $table->string('keteter')->nullable();
            $table->string('tidak_ada_barang')->nullable();
            $table->string('trouble_mesin')->nullable();
            $table->string('trouble_chemical')->nullable();
            $table->string('trouble_utility')->nullable();
            $table->string('trouble_ng')->nullable();
            $table->string('mati_lampu')->nullable();
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
        Schema::dropIfExists('productions');
    }
}
