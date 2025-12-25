<?php

namespace Database\Seeders;

use App\Models\LeaderboardEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaderboardSeeder extends Seeder
{
    public function run(): void
    {
        $period = now()->startOfMonth()->toDateString();
        $rank = 1;

        User::orderBy('id')->each(function (User $user) use (&$rank, $period) {
            LeaderboardEntry::firstOrCreate(
                ['user_id' => $user->id, 'period' => $period],
                ['rank' => $rank++]
            );
        });
    }
}
