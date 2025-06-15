<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompositeUniqueIndexToSubjects extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Drop existing unique index on name if exists
            // Removed getDoctrineSchemaManager call due to error
            // Just attempt to drop index, ignore if not exists
            try {
                $table->dropUnique('subjects_name_unique');
            } catch (\Exception $e) {
                // Index does not exist, ignore
            }

            // Add composite unique index on user_id and name
            $table->unique(['user_id', 'name'], 'subjects_user_id_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropUnique('subjects_user_id_name_unique');
            $table->unique('name', 'subjects_name_unique');
        });
    }
}
