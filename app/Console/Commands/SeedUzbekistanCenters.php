<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\UzbekistanLearningCentersSeeder;

class SeedUzbekistanCenters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:uzbekistan-centers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with Uzbekistan learning centers from JSON file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to seed Uzbekistan learning centers...');
        
        $seeder = new UzbekistanLearningCentersSeeder();
        $seeder->setCommand($this);
        $seeder->run();
        
        $this->info('Uzbekistan learning centers seeding completed!');
        
        return Command::SUCCESS;
    }
}
