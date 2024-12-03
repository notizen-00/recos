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
            $table->foreignId('classification_id')->constrained('classifications');
            $table->foreignId('priority_id')->constrained('priorities');
            $table->string('no')->nullable();
            $table->string('full_number')->nullable();
            $table->string('subject');
            $table->string('content')->nullable();
            $table->string('code');
            $table->string('mail_place');
            $table->string('mail_date');
            $table->string('sign_user');
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