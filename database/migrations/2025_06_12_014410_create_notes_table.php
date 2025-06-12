<?php
// FILE: database/migrations/YYYY_MM_DD_HHMMSS_create_notes_table.php (replace YYYY_MM_DD_HHMMSS with actual timestamp)

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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade'); // Foreign key to subjects table
            $table->string('title');
            $table->longText('content'); // Using longText for potentially large note content
            $table->timestamps();

            // Add index for faster lookups on subject_id
            $table->index('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};