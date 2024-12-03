<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{

    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('radius');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('units');
    }
}
