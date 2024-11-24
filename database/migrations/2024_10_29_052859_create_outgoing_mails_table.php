<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutgoingMailsTable extends Migration
{

    public function up()
    {
        Schema::create('outgoing_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sub_type_id')->constrained('sub_types');
            $table->string('no');
            $table->string('full_number');
            $table->string('subject');
            $table->string('content');
            $table->string('code');
            $table->string('mail_date');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('outgoing_mails');
    }
}
