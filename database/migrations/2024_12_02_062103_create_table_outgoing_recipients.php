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
        Schema::create('outgoing_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outgoing_mail_id')
                ->constrained('outgoing_mails');
            $table->foreignId('recipient_unit_id')
                ->constrained('units');
            $table->foreignId('sender_id')
                ->constrained('users');
            $table->foreignId('recipient_id')
                ->constrained('users');
            $table->enum('recipient_type', [
                'to',
                'cc'
            ]); // to itu tujuan utama, cc tembusan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_recipients');
    }
};
