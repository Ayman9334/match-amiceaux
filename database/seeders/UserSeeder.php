<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pw = bcrypt("Ayman123");
        for ($i = 0; $i <= 5; $i++) {
            $e = $i == 0 ? null : $i;
            User::create([
                "nom" => "Ayman Test",
                "email" => "a$e@g.c",
                "password" => $pw,
                "n_telephone" => "0658322310",
                "code_postal" => "80000",
                "ville" => "Agadir",
                "region" => "ARAreg",
                "adresse" => "N1321 TYPE B SECT N AL MASSIRA AGADIR 80000",
                "niveau" => "A1",
                "categorie" => "u6cat",
                "league" => "L1",
            ]);
        }
    }
}
