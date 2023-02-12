<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ng_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('detransaction_id');
            $table->string('over_paint')->nullable();
            $table->string('bintik_or_pin_hole')->nullable();
            $table->string('minyak_or_map')->nullable();
            $table->string('cotton')->nullable();
            $table->string('no_paint_or_tipis')->nullable();
            $table->string('scratch')->nullable();
            $table->string('air_pocket')->nullable();
            $table->string('kulit_jeruk')->nullable();
            $table->string('kasar')->nullable();
            $table->string('karat')->nullable();
            $table->string('water_over')->nullable();
            $table->string('minyak_kering')->nullable();
            $table->string('dented')->nullable();
            $table->string('keropos')->nullable();
            $table->string('nempel_jig')->nullable();
            $table->string('lainnya')->nullable();
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
        Schema::dropIfExists('ng_transactions');
    }
}
