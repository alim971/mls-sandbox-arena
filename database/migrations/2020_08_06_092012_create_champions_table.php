<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('champions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('role')->nullable();
            $table->unsignedInteger('burst');
            $table->unsignedInteger('poke');
            $table->unsignedInteger('basic');
            $table->unsignedInteger('tank');
            $table->unsignedInteger('sustain');
            $table->unsignedInteger('utility');
            $table->unsignedInteger('mobility');
            $table->unsignedInteger('difficulty');
//            $table->string('version');
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
        Schema::dropIfExists('champions');
    }
}
