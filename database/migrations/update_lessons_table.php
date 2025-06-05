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
        Schema::table('lessons', function (Blueprint $table) {
            // Add any new columns here
            // For example:
            // $table->string('new_column')->nullable()->after('existing_column');
            
            // Or modify existing columns:
            // $table->string('existing_column', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            // Drop any columns added in up()
            // For example:
            // $table->dropColumn('new_column');
        });
    }
};
