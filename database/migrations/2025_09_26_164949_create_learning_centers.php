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
        // 1) learning_centers
        Schema::create('learning_centers', function (Blueprint $table) {
            $table->id();
            $table->text('logo')->nullable();
            $table->string('name');
            $table->string('type')->nullable();
            $table->text('about')->nullable();
            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('region')->nullable();
            $table->text('address')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->integer('ratings_total')->default(0);
            $table->string('location')->nullable();
            $table->foreignId('users_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('student_count')->default(0);
            $table->integer('total_reyting')->default(0);
            $table->string('status')->default('active');
            $table->boolean('checked')->default(false);
            $table->string('tin')->unique()->nullable()->comment('STIR raqami');
            $table->text('legal_address')->nullable();
            $table->string('territory')->nullable();
            $table->string('license_number')->nullable();
            $table->date('license_registration_date')->nullable();
            $table->date('license_validity_period')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('ifut_code')->nullable();
        
            $table->timestamps();
            
            // Indexlar
            $table->index('province');
            $table->index('type');
        });


        // 3) subjects_of_learning_centers
        Schema::create('subjects_of_learning_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->string('subject_name');
            $table->timestamps();
        });

        // 4) learning_centers_images
        Schema::create('learning_centers_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->text('image')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_url')->nullable();
            $table->text('photo_reference')->nullable();
            $table->integer('width')->default(0);
            $table->integer('height')->default(0);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
        });

        // 5) learning_centers_comments
        Schema::create('learning_centers_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->text('comment');
            $table->boolean('checked')->default(false);
            $table->timestamps();
        });

        // 7) teachers
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
        });

        // 6) teacher_subjects (junction table)
        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects_of_learning_centers')->onDelete('cascade');
            $table->string('subject_type')->nullable();
            $table->string('subject_icon')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->string('currency')->nullable();
            $table->string('period')->nullable();
            $table->timestamps();
        });

        // 8) favorites
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->integer('rating')->nullable();
            $table->timestamps();
        });

        // 9) learning_centers_calendar
        Schema::create('learning_centers_calendar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->string('weekdays');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->timestamps();
        });


        // 11) learning_centers_connect
        Schema::create('learning_centers_connect', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->string('connection_name');
            $table->string('connection_icon')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        // 12) need_teacher
        Schema::create('need_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_center_id');
            $table->string('subject_name');
            $table->string('subject_type')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('learning_center_id')->references('id')->on('learning_centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subjects');
        Schema::dropIfExists('learning_centers_connect');
        Schema::dropIfExists('learning_centers_calendar');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('learning_centers_comments');
        Schema::dropIfExists('learning_centers_images');
        Schema::dropIfExists('subjects_of_learning_centers');
        Schema::dropIfExists('learning_centers');
        Schema::dropIfExists('need_teacher');
    }
};
