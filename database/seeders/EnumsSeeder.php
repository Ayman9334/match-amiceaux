<?php

namespace Database\Seeders;

use App\Models\TypeEnum;
use App\Models\TypeEnumsDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnumsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeEnum::create([
            "libelle" => "categories",
            "code" => "cat",
        ]);
        TypeEnum::create([
            "libelle" => "niveau",
            "code" => "niv",
        ]);
        for ($i = 6; $i <= 20; $i++) {
            TypeEnumsDetail::create([
                "type_enum_id" => 1,
                "libelle" => "U$i",
                "code" => "u$i" . "cat",
            ]);
            TypeEnumsDetail::create([
                "type_enum_id" => 1,
                "libelle" => "U$i Féminine",
                "code" => "u$i" . "fcat",
            ]);
        }
        TypeEnumsDetail::create([
            "type_enum_id" => 1,
            "libelle" => "Seniors",
            "code" => "snrcat",
        ]);
        TypeEnumsDetail::create([
            "type_enum_id" => 1,
            "libelle" => "Vétérans",
            "code" => "vtrcat",
        ]);

        foreach (["A1", "A2", "B1", "B2", "C1", "C2"] as $nv) {
            TypeEnumsDetail::create([
                "type_enum_id" => 2,
                "libelle" => $nv,
                "code" => $nv,
            ]);
        }
    }
}
