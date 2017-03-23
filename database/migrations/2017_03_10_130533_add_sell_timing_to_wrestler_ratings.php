<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSellTimingToWrestlerRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wrestler_ratings', function (Blueprint $table) {
            $table->double('sell_timing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wrestler_ratings', function (Blueprint $table) {
            $table->dropColumn('sell_timing');
        });
    }
}
