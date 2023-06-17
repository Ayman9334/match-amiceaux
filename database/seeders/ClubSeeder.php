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
        Club::create([
            'nom_club' => 'hasaniya',
            'proprietaire_id' => 8,
            'club_code' => Str::random(12)
        ]);

        ClubMember::create([
            "member_id" => 2,
            "club_id" => 1,
            "member_role" => 'proprietaire',
        ]);

        for ($i = 3; $i <= 7; $i++) {
            ClubMember::create([
                "member_id" => $i,
                "club_id" => 1,
            ]);
        }

        ClubMember::create([
            "member_id" => 8,
            "club_id" => 2,
            "member_role" => 'proprietaire',
        ]);

        for ($i = 9; $i <= 13; $i++) {
            ClubMember::create([
                "member_id" => $i,
                "club_id" => 2,
            ]);
        }
    }
}
