<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSjsTableLbpGr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sjs', function (Blueprint $table) {
            $table->dropColumn(['lbp', 'gr']);
            $table->string('lbp_gr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sjs', function (Blueprint $table) {
            $table->dropColumn('lbp_gr');
            $table->string('lbp')->nullable();
            $table->string('gr')->nullable();
        });
    }
}
