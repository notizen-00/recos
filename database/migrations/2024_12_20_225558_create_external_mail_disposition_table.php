<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('external_mails_disposition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('external_mail_id')
                ->constrained('external_mails');
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_mail_disposition');
    }
};
