<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'AI',
            'Logistics',
            'Energy',
            'Governance',
            'Manufacturing',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['tag_name' => $tag]);
        }
    }
}
