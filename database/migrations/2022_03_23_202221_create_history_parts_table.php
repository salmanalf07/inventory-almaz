<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_parts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cust_id');
            $table->bigInteger('part_id');
            $table->string('name_local')->nullable();
            $table->string('part_no')->nullable();
            $table->string('part_name')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('periode')->nullable();
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
        Schema::dropIfExists('history_parts');
    }
}
