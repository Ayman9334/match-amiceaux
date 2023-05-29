<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Club::create([
            'nom_club' => 'itihad',
            'proprietaire_id' => 1,
            'club_code' => Str::random(12)
        ]);

        ClubMember::create([
            "member_id" => 1,
            "club_id" => 1,
            "member_role" => 'proprietaire',
        ]);

        for ($i = 2; $i <= 6; $i++) {
            ClubMember::create([
                "member_id" => $i,
                "club_id" => 1,
            ]);
        }
    }
}
