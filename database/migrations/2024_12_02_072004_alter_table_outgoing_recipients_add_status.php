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
        Schema::table('outgoing_recipients', function (Blueprint $table) {
            $table->enum('status', [
                '0',
                '1'
            ])
                ->default('0'); // 0 not publish (belum disetujui sampai akhir), 1 publish (kalau sudah disetujui)
            $table->enum('status_read', [
                '0',
                '1'
            ])
                ->default('0'); // 0 belum dibaca, 1 dibaca
            $table->dateTime('read_at')
                ->nullable(); // waktu dibaca
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outgoing_recipients', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('status_read');
            $table->dropColumn('read_at');
        });
    }
};
