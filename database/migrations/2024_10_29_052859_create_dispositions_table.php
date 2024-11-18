<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDispositionsTable extends Migration
{

    public function up()
    {
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('incoming_mail_id')->constrained('incoming_mails');
            $table->foreignId('priority_id')->constrained('priorities');
            $table->foreignId('user_id')->constrained('users');
            $table->string('forward');
            $table->string('content');
            $table->string('expired_date');
            $table->string('note');
            $table->string('read_at');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::drop('dispositions');
    }
}
