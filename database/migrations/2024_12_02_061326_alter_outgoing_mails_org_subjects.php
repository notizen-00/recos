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
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->foreignId('org_subject_id')
                ->nullable()
                ->constrained('org_subjects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->dropColumn('org_subject_id');
        });
    }
};
