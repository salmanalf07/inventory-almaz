<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->bigInteger('prodstd_id')->unsigned()->after('id');
            $table->string('shift')->default(1)->after('prodstd_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('prodstd_id');
            $table->dropColumn('shift');
        });
    }
}
