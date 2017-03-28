<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToWrestlers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wrestlers', function (Blueprint $table) {
            $table->text('bio')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('gender')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wrestlers', function (Blueprint $table) {
            $table->dropColumn('bio');
            $table->dropColumn('twitter');
            $table->dropColumn('instagram');
            $table->dropColumn('gender');
        });
    }
}
