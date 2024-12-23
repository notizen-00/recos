<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternalMailTable extends Migration
{

    public function up()
    {
        Schema::create('external_mails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classification_id')
                ->constrained('classifications');
            $table->foreignId('priority_id')
                ->constrained('priorities');
            $table->foreignId('external_type_id')
                ->constrained('external_types');
            $table->string('agenda_number');
            $table->date('agenda_date');
            $table->string('letter_number');
            $table->date('letter_date');
            $table->string('subject');
            $table->string('from_user');
            $table->unsignedBigInteger('from_user_id')
                ->nullable();
            $table->foreign('from_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
//            $table->foreignId('from_user_id')
//                ->constrained('users');
            $table->unsignedBigInteger('from_user_departments_id')
                ->nullable();
            $table->foreign('from_user_departments_id')
                ->references('id')
                ->on('detail_departments')
                ->onDelete('restrict');
//            $table->foreignId('from_user_departments_id')
//                ->constrained('detail_departments');
            $table->string('from_ext');
            $table->string('forwarded_to');
            $table->string('forwarded_to_id')
                ->constrained('users');
            $table->string('forwarded_to_departments_id')
                ->constrained('detail_departments');
            $table->string('forwarded_date');
            $table->string('description');
            $table->longText('file_pdf')
                ->nullable();
            $table->string('status');
            $table->foreignId('user_id')
                ->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('external_mails');
    }
}
