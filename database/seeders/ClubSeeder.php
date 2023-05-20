<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Club::create([
            'nom_club' => 'itihad',
            'niveau'=> 'A2',
            'ligue' => 'L2',
            'categorie' => 'u6cat',
        ]);
        ClubMember::create([
            "member_id" => 1,
            "club_id" => 1,
            "member_role" => 'proprietaire',
        ]);
    }
}
