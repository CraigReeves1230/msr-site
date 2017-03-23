<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWrestlerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wrestler_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('wrestler_id');
            $table->integer('user_id')->nullable();
            $table->double('striking')->nullable();
            $table->double('submission')->nullable();
            $table->double('throws')->nullable();
            $table->double('movement')->nullable();
            $table->double('mat_and_chain')->nullable();
            $table->double('setting_up')->nullable();
            $table->double('bumping')->nullable();
            $table->double('technical')->nullable();
            $table->double('high_fly')->nullable();
            $table->double('power')->nullable();
            $table->double('reaction')->nullable();
            $table->double('durability')->nullable();
            $table->double('conditioning')->nullable();
            $table->double('basing')->nullable();
            $table->double('shine')->nullable();
            $table->double('heat')->nullable();
            $table->double('comebacks')->nullable();
            $table->double('selling')->nullable();
            $table->double('ring_awareness')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wrestler_ratings');
    }
}
