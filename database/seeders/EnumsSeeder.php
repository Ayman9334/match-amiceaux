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
            "libelle" => "catégories",
            "code" => "cat",
        ]);
        TypeEnum::create([
            "libelle" => "niveaus",
            "code" => "niv",
        ]);
        TypeEnum::create([
            "libelle" => "régions",
            "code" => "reg",
        ]);

        TypeEnum::create([
            "libelle" => "ligues",
            "code" => "lg",
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

        foreach (["A1", "A2", "B1", "B2", "C1", "C2"] as $niveau) {
            TypeEnumsDetail::create([
                "type_enum_id" => 2,
                "libelle" => $niveau,
                "code" => $niveau,
            ]);
        }

        $regions = [
            'Auvergne-Rhône-Alpes' => 'ARAreg',
            'Bourgogne-Franche-Comté' => 'BFCreg',
            'Bretagne' => 'BREreg',
            'Centre-Val de Loire' => 'CVLreg',
            'Corse' => 'CORreg',
            'Grand Est' => 'GESreg',
            'Hauts-de-France' => 'HDFreg',
            'Île-de-France' => 'IDFreg',
            'Normandie' => 'NORreg',
            'Nouvelle-Aquitaine' => 'NAQreg',
            'Occitanie' => 'OCCreg',
            'Pays de la Loire' => 'PDLreg',
            'Provence-Alpes-Côte d\'Azur' => 'PACreg',
        ];

        foreach($regions as $region => $code){
            TypeEnumsDetail::create([
                "type_enum_id" => 3,
                "libelle" => $region,
                "code" => $code,
            ]);
        }

        $leagues = [
            'Ligue 1' => 'L1',
            'Ligue 2' => 'L2',
            'National 1' => 'N1',
            'National 2' => 'N2',
            'National 3' => 'N3',
            'Coupe de France' => 'CDF',
            'Coupe de la Ligue' => 'CDL',
            'Trophée des Champions' => 'TDC',
        ];

        foreach($leagues as $league => $code){
            TypeEnumsDetail::create([
                "type_enum_id" => 4,
                "libelle" => $league,
                "code" => $code,
            ]);
        }

    }
}
