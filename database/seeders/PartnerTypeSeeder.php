<?php

namespace Database\Seeders;

use App\Models\PartnershipType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'School Partner',
            'Hotel Partner',
            'University Partner',
            'Government Partner',
            'Industry Partner',
            'International Partner',
            'Recruitment Partner',
            'Community Partner',
            'Event Partner',
            'Media Partner',
            'Training Partner',
            'Referral Partner',
        ];

        foreach ($types as $type) {
            PartnershipType::create([
                'name' => $type,
            ]);
        }
    }
}
