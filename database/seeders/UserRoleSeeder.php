<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Office;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        $officeEu = Office::where('region', 'Europe')->first();
        $officeAsia = Office::where('region', 'Asia')->first();
        $officeNa = Office::where('region', 'North America')->first();

        // ============================
        // Consultant (Regular User)
        // ============================
        User::create([
            'name' => 'Ali Consultant',
            'email' => 'consultant@dkn.test',
            'password' => Hash::make('password123'),
            'role' => 'CONSULTANT',
            'region' => 'Europe',
            'status' => 'ACTIVE',
            'office_id' => $officeEu?->id,
        ]);

        // ============================
        // Knowledge Champion
        // ============================
        User::create([
            'name' => 'Sara Champion',
            'email' => 'champion@dkn.test',
            'password' => Hash::make('password123'),
            'role' => 'CHAMPION',
            'region' => 'Asia',
            'status' => 'ACTIVE',
            'office_id' => $officeAsia?->id,
        ]);

        // ============================
        // Executive
        // ============================
        User::create([
            'name' => 'James Executive',
            'email' => 'executive@dkn.test',
            'password' => Hash::make('password123'),
            'role' => 'EXECUTIVE',
            'region' => 'North America',
            'status' => 'ACTIVE',
            'office_id' => $officeNa?->id,
        ]);

        // ============================
        // Governance Council Member
        // ============================
        User::create([
            'name' => 'Linda Governance',
            'email' => 'governance@dkn.test',
            'password' => Hash::make('password123'),
            'role' => 'GOVERNANCE',
            'region' => 'Europe',
            'status' => 'ACTIVE',
            'office_id' => $officeEu?->id,
        ]);

        // ============================
        // System Administrator
        // ============================
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@dkn.test',
            'password' => Hash::make('password123'),
            'role' => 'ADMIN',
            'region' => 'Global',
            'status' => 'ACTIVE',
            'office_id' => $officeEu?->id,
        ]);
    }
}
