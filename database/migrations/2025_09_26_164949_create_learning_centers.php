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
            $table->string('logo')->nullable();
            $table->string('name');
            $table->string('type')->nullable();
            $table->text('about')->nullable();
            $table->string('province')->nullable();
            $table->string('region')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->integer('student_count')->default(0);
            $table->timestamps();
        });

        // 2) subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        // 3) subjects_of_learning_centers
        Schema::create('subjects_of_learning_centers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('price')->nullable();
            $table->timestamps();
        });

        // 4) learning_centers_images
        Schema::create('learning_centers_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->string('image');
            $table->timestamps();
        });

        // 5) learning_centers_comments
        Schema::create('learning_centers_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });

        // 6) calendar
        Schema::create('calendar', function (Blueprint $table) {
            $table->id();
            $table->string('weekdays');
            $table->timestamps();
        });

        // 7) teachers
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->string('name');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->text('about')->nullable();
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
            $table->foreignId('calendar_id')->constrained('calendar')->onDelete('cascade');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->timestamps();
        });

        // 10) connection
        Schema::create('connection', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 11) learning_centers_connect
        Schema::create('learning_centers_connect', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learning_centers_id')->constrained('learning_centers')->onDelete('cascade');
            $table->foreignId('connection_id')->constrained('connection')->onDelete('cascade');
            $table->string('url')->nullable();
            $table->timestamps();
        });

        // 12) need_teacher
        Schema::create('need_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_center_id');
            $table->unsignedBigInteger('subject_id');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('learning_center_id')->references('id')->on('learning_centers')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('learning_centers_connect');
        Schema::dropIfExists('connection');
        Schema::dropIfExists('learning_centers_calendar');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('calendar');
        Schema::dropIfExists('learning_centers_comments');
        Schema::dropIfExists('learning_centers_images');
        Schema::dropIfExists('subjects_of_learning_centers');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('learning_centers');
        Schema::dropIfExists('need_teacher');
    }
};
