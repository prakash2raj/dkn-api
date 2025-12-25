<?php

namespace Database\Seeders;

use App\Models\ExpertiseProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpertiseProfileSeeder extends Seeder
{
    public function run(): void
    {
        User::orderBy('id')->each(function (User $user) {
            ExpertiseProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'skills' => 'Knowledge Management, Collaboration',
                    'experience_level' => 'Intermediate',
                ]
            );
        });
    }
}
