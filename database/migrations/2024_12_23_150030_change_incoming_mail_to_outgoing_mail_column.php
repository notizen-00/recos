<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dispositions', function (Blueprint $table) {

            $table->dropForeign(['incoming_mail_id']);
            $table->dropColumn('incoming_mail_id');

            $table->foreignId('outgoing_mail_id')->constrained('outgoing_mails');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispositions', function (Blueprint $table) {

            $table->dropForeign(['outgoing_mail_id']);
            $table->dropColumn('outgoing_mail_id');

            $table->foreignId('incoming_mail_id')->constrained('incoming_mails');
        });
    }
};
