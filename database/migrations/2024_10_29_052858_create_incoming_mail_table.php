<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIncomingMailTable extends Migration
{

    public function up()
    {
        Schema::create('incoming_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classification_id')->constrained('classifications');
            $table->foreignId('priority_id')->constrained('priorities');
            $table->foreignId('type_id')->constrained('types');
            $table->foreignId('unit_id')->constrained('units');
            $table->string('no');
            $table->string('full_number');
            $table->string('description');
            $table->string('sign_date');
            $table->string('sign_place');
            $table->string('sign_user');
            $table->string('status');
            $table->string('publish_date');
            $table->string('user_id_created');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('incoming_mails');
    }
}
