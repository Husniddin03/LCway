<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * These indexes optimize the search functionality in SearchService.
     * Run this migration after implementing the smart search features.
     */
    public function up(): void
    {
        // learning_centers table indexes
        Schema::table('learning_centers', function (Blueprint $table) {
            // Basic indexes for filtering
            $table->index('name', 'idx_lc_name');
            $table->index('type', 'idx_lc_type');
            $table->index('region', 'idx_lc_region');
            $table->index('province', 'idx_lc_province');
            $table->index('status', 'idx_lc_status');
            
            // Composite index for location-based queries
            $table->index(['region', 'province'], 'idx_lc_location');
            
            // Composite index for type + location filtering
            $table->index(['type', 'region', 'status'], 'idx_lc_type_region_status');
            
            // Full-text index for name and address (MySQL 5.6+)
            // Note: Run this separately if your MySQL version supports it
            try {
                $table->fullText(['name', 'address'], 'ft_lc_name_address');
                $table->fullText(['region', 'province'], 'ft_lc_region_province');
            } catch (\Exception $e) {
                // Full-text might not be supported, continue without it
            }
        });

        // subjects_of_learning_centers table indexes
        Schema::table('subjects_of_learning_centers', function (Blueprint $table) {
            // Composite index for center-subject lookups
            $table->index(['learning_centers_id', 'subject_name'], 'idx_slc_center_subject');
            
            // Index for subject name searches
            $table->index('subject_name', 'idx_slc_subject_name');
            
            // Full-text for subject names
            try {
                $table->fullText('subject_name', 'ft_slc_subject_name');
            } catch (\Exception $e) {
                // Continue without full-text
            }
        });

        // teachers table indexes
        Schema::table('teachers', function (Blueprint $table) {
            $table->index(['learning_centers_id', 'name'], 'idx_teachers_center_name');
            $table->index('name', 'idx_teachers_name');
        });

        // need_teacher table indexes
        Schema::table('need_teacher', function (Blueprint $table) {
            $table->index(['learning_center_id', 'subject_name'], 'idx_nt_center_subject');
            $table->index('subject_name', 'idx_nt_subject_name');
            $table->index('created_at', 'idx_nt_created_at');
        });

        // teacher_subjects table indexes
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->index(['subject_id', 'price'], 'idx_ts_subject_price');
            $table->index('price', 'idx_ts_price');
        });

        // favorites table indexes (for rating calculations)
        Schema::table('favorites', function (Blueprint $table) {
            $table->index(['learning_centers_id', 'rating'], 'idx_fav_center_rating');
            $table->index(['users_id', 'learning_centers_id'], 'idx_fav_user_center');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // learning_centers
        Schema::table('learning_centers', function (Blueprint $table) {
            $table->dropIndex(['idx_lc_name']);
            $table->dropIndex(['idx_lc_type']);
            $table->dropIndex(['idx_lc_region']);
            $table->dropIndex(['idx_lc_province']);
            $table->dropIndex(['idx_lc_status']);
            $table->dropIndex(['idx_lc_location']);
            $table->dropIndex(['idx_lc_type_region_status']);
            
            try {
                $table->dropFullText(['ft_lc_name_address']);
                $table->dropFullText(['ft_lc_region_province']);
            } catch (\Exception $e) {
                // Ignore if doesn't exist
            }
        });

        // subjects_of_learning_centers
        Schema::table('subjects_of_learning_centers', function (Blueprint $table) {
            $table->dropIndex(['idx_slc_center_subject']);
            $table->dropIndex(['idx_slc_subject_name']);
            
            try {
                $table->dropFullText(['ft_slc_subject_name']);
            } catch (\Exception $e) {
                // Ignore
            }
        });

        // teachers
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropIndex(['idx_teachers_center_name']);
            $table->dropIndex(['idx_teachers_name']);
        });

        // need_teacher
        Schema::table('need_teacher', function (Blueprint $table) {
            $table->dropIndex(['idx_nt_center_subject']);
            $table->dropIndex(['idx_nt_subject_name']);
            $table->dropIndex(['idx_nt_created_at']);
        });

        // teacher_subjects
        Schema::table('teacher_subjects', function (Blueprint $table) {
            $table->dropIndex(['idx_ts_subject_price']);
            $table->dropIndex(['idx_ts_price']);
        });

        // favorites
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropIndex(['idx_fav_center_rating']);
            $table->dropIndex(['idx_fav_user_center']);
        });
    }
};
