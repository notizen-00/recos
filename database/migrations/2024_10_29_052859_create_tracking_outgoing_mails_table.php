<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingOutgoingMailsTable extends Migration
{

    public function up()
    {
        Schema::create('tracking_outgoing_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outgoing_mail_id')->constrained('outgoing_mails');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('sender_id')->constrained('users');
            $table->foreignId('to')->constrained('users');
            $table->string('status');
            $table->string('note')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('forward_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('tracking_outgoing_mails');
    }
}