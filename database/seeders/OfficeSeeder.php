<?php

namespace Database\Seeders;

use App\Models\Office;
use App\Models\RegulatoryConstraint;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        $offices = [
            ['office_id' => 'OFF-EU', 'region' => 'Europe', 'network_status' => 'ONLINE'],
            ['office_id' => 'OFF-NA', 'region' => 'North America', 'network_status' => 'ONLINE'],
            ['office_id' => 'OFF-AS', 'region' => 'Asia', 'network_status' => 'ONLINE'],
        ];

        foreach ($offices as $data) {
            $office = Office::firstOrCreate(['office_id' => $data['office_id']], $data);

            RegulatoryConstraint::firstOrCreate(
                [
                    'regulation_id' => 'REG-' . $data['office_id'],
                ],
                [
                    'region' => $data['region'],
                    'office_id' => $office->id,
                ]
            );
        }
    }
}
