<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cust_id');
            $table->string('name_local');
            $table->string('part_no')->nullable();
            $table->string('part_name');
            $table->float('price')->nullable();
            $table->float('sa_dm')->nullable();
            $table->float('qty_pack')->nullable();
            $table->string('type_pack')->nullable();
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
        Schema::dropIfExists('parts');
    }
}
