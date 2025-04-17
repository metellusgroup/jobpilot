<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new columns
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('noc_available')->nullable();
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->string('driving_license')->nullable();
            $table->unsignedBigInteger('candidate_visa_status_id')->nullable();
            $table->unsignedBigInteger('candidate_license_status_id')->nullable();
            $table->string('current_salary')->nullable();
            $table->string('expected_salary')->nullable();
            $table->unsignedBigInteger('default_cv')->nullable();
        });

        // Drop existing status column
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Recreate status column with new enum values
        DB::statement("ALTER TABLE candidates ADD status ENUM('available_immediately', 'available_in15days', 'available_in30days', 'available_in45days', 'available_in60days', 'available_in90days') NOT NULL DEFAULT 'available_immediately'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First drop the enum column
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        // Recreate original status column
        DB::statement("ALTER TABLE candidates ADD status ENUM('available', 'not_available', 'available_in') NOT NULL DEFAULT 'available'");

        // Drop other columns
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn([
                'noc_available',
                'nationality_id',
                'driving_license',
                'candidate_visa_status_id',
                'candidate_license_status_id',
                'current_salary',
                'expected_salary'
            ]);
        });
    }
}; 