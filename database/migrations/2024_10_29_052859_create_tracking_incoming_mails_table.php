<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTrackingIncomingMailsTable extends Migration
{

    public function up()
    {
        Schema::create('tracking_incoming_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incoming_mail_id')->constrained('incoming_mails')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('user_id')->constrained('users');
            $table->string('to');
            $table->string('status');
            $table->string('note');
            $table->string('read_at');
            $table->string('forward_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('tracking_incoming_mails');
    }
}
