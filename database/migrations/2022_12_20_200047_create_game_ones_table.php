<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameOnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_ones', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('digit');
            $table->date('date');  
            $table->time('time');                                               
            $table->unsignedInteger('bid');          //betting amount
            $table->boolean('win')->default(false);  //winned or failed
            $table->boolean('seen')->default(false); // the  user has seen his betting result or not
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('game_ones');
    }
}
