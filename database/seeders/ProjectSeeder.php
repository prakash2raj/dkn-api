<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'name' => 'Smart Logistics Transformation',
            'domain' => 'Logistics',
            'status' => 'ACTIVE'
        ]);

        Project::create([
            'name' => 'Renewable Energy Grid Optimisation',
            'domain' => 'Renewable Energy',
            'status' => 'ACTIVE'
        ]);

        Project::create([
            'name' => 'AI for Smart Manufacturing',
            'domain' => 'Smart Manufacturing',
            'status' => 'ACTIVE'
        ]);

        Project::create([
            'name' => 'Cross-Regional Digital Integration',
            'domain' => 'Digital Transformation',
            'status' => 'ACTIVE'
        ]);
    }
}
