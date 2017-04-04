<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConversationLockedToWrestlers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wrestlers', function(Blueprint $table){
            $table->boolean('conversation_locked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wrestlers', function(Blueprint $table){
            $table->dropColumn('wrestlers');
        });
    }
}
