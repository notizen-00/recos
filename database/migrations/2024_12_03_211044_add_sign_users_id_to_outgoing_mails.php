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
        Schema::table('outgoing_mails', function (Blueprint $table) {
            $table->foreignId('sign_user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outgoing_mails', function (Blueprint $table) {
    
            $table->dropForeign(['sign_user_id']); 

   
            $table->dropColumn('sign_user_id');
        });
    }
};