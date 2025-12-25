<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'CONSULTANT',
            'CHAMPION',
            'EXECUTIVE',
            'GOVERNANCE',
            'ADMIN',
        ];

        $roleMap = [];
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['role_name' => $roleName]);
            $roleMap[$roleName] = $role->id;
        }

        // Backfill existing users to link role_id to the enum role field
        User::query()
            ->whereIn('role', array_keys($roleMap))
            ->each(function (User $user) use ($roleMap) {
                $user->role_id = $roleMap[$user->role];
                $user->save();
            });
    }
}
