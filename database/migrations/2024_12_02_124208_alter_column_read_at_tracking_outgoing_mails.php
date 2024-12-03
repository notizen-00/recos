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
        Schema::table('tracking_outgoing_mails', function (Blueprint $table) {
            $table->timestamp('read_at')
                ->nullable()
                ->default(null)
                ->change();
            $table->timestamp('forward_date')
                ->nullable()
                ->default(null)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {}
};
