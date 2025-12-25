<?php

namespace Database\Seeders;

use App\Models\Workspace;
use Illuminate\Database\Seeder;

class WorkspaceSeeder extends Seeder
{
    public function run(): void
    {
        $workspaces = [
            ['name' => 'Global Knowledge Base', 'visibility' => 'PUBLIC'],
            ['name' => 'Regional Insights', 'visibility' => 'INTERNAL'],
        ];

        foreach ($workspaces as $data) {
            Workspace::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
