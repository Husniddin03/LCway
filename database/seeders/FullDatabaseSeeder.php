<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    LearningCenter,
    Subject,
    SubjectsOfLearningCenter,
    LearningCentersImage,
    LearningCentersComment,
    Calendar,
    Teacher,
    Favorite,
    LearningCentersCalendar,
    Connection,
    LearningCentersConnect,
    NeedTeacher
};

class FullDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Asosiy jadval: Learning Centers
        LearningCenter::factory(100)
        ->has(LearningCentersImage::factory(4), 'images')
        ->has(SubjectsOfLearningCenter::factory(10), 'subjects')
        ->has(LearningCentersComment::factory(3), 'comments')
        ->has(Teacher::factory(10), 'teachers')
        ->has(LearningCentersConnect::factory(4), 'connections')
        ->has(LearningCentersCalendar::factory(6), 'calendar')
        ->has(Favorite::factory(1), 'favorites')
        ->has(NeedTeacher::factory(2), 'needTeachers')
        ->create();
    }
}
