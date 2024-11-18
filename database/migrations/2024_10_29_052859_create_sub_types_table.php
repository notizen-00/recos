<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubTypesTable extends Migration
{

    public function up()
    {
        Schema::create('sub_types', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade')->onUpdate('cascade');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('sub_types');
    }
}
