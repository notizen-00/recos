<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispositionsTable extends Migration
{

    public function up()
    {
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internal_mail_id')
                ->constrained('outgoing_mails');
            $table->string('recipient_user');
            $table->foreignId('recipient_user_id')
                ->constrained('users');
            $table->foreignId('recipient_user_detail_departments_id')
                ->constrained('detail_departments')
                ->name('fk_detail_departments');
            $table->foreignId('follow_up_type_id')
                ->constrained('follow_up_types');
            $table->longText('follow_up_message');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down()
    {
        Schema::drop('dispositions');
    }
}
