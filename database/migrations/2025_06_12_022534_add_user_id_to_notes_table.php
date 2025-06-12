<?php
// FILE: database/migrations/YYYY_MM_DD_HHMMSS_add_user_id_to_notes_table.php
// (Create this file using: php artisan make:migration add_user_id_to_notes_table)

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
        Schema::table('notes', function (Blueprint $table) {
            // Add user_id column as a foreign key
            // Ensure it's placed before subject_id if you want a specific order,
            // otherwise, after subject_id works too.
            $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Drop the foreign key constraint
            $table->dropColumn('user_id');    // Drop the column
        });
    }
};