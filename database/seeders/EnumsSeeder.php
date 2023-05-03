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
    }
}
