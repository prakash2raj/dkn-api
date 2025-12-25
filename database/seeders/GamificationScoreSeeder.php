<?php

namespace Database\Seeders;

use App\Models\GamificationScore;
use App\Models\User;
use Illuminate\Database\Seeder;

class GamificationScoreSeeder extends Seeder
{
    public function run(): void
    {
        User::orderBy('id')->each(function (User $user, $index) {
            GamificationScore::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'points' => 100 * ($index + 1),
                    'badges' => 'Starter',
                ]
            );
        });
    }
}
