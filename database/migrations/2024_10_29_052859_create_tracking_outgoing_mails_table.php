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
        Schema::drop('tracking_outgoing_mails');
    }
}
