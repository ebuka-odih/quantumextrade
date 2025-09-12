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
        Schema::table('user_ai_traders', function (Blueprint $table) {
            // Add the user_id column as nullable UUID
            $table->uuid('user_id')->nullable()->after('id');
        });

        Schema::table('user_ai_traders', function (Blueprint $table) {
            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Add indexes
            $table->index(['user_id', 'status']);
            $table->unique(['user_id', 'ai_trader_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_ai_traders', function (Blueprint $table) {
            // Drop foreign key constraint and column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};