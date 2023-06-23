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
        $elems = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
        $pw = bcrypt("Ayman123");
        User::create([
            "nom" => "Admin",
            "email" => "admin@g.c",
            "password" => $pw,
            "n_telephone" => "0658322310",
            "code_postal" => "80000",
            "ville" => "Agadir",
            "region" => "ARAreg",
            "adresse" => "N1321 TYPE B SECT N AL MASSIRA AGADIR 80000",
            "niveau" => fake()->randomElement($elems),
            "categorie" => "u6cat",
            "league" => "L1",
            "role" => "admin"
        ]);

        for ($i = 0; $i <= 5; $i++) {
            $e = $i == 0 ? null : $i;
            User::create([
                "nom" => "Ayman Test$e",
                "email" => "a$e@g.c",
                "password" => $pw,
                "n_telephone" => "0612345678",
                "code_postal" => "80000",
                "ville" => "Agadir",
                "region" => "ARAreg",
                "adresse" => "N1321 TYPE B SECT N AL MASSIRA AGADIR 80000",
                "niveau" => fake()->randomElement($elems),
                "categorie" => "u6cat",
                "league" => "L1",
            ]);
        }
        for ($i = 0; $i <= 5; $i++) {
            $e = $i == 0 ? null : $i;
            User::create([
                "nom" => "Najat Test$e",
                "email" => "n$e@g.c",
                "password" => $pw,
                "n_telephone" => "0612345678",
                "code_postal" => "80000",
                "ville" => "Agadir",
                "region" => "ARAreg",
                "adresse" => "N1321 TYPE B SECT N AL MASSIRA AGADIR 80000",
                "niveau" => fake()->randomElement($elems),
                "categorie" => "u6cat",
                "league" => "L1",
            ]);
        }
        for ($i = 0; $i <= 5; $i++) {
            $e = $i == 0 ? null : $i;
            User::create([
                "nom" => "Solo user$e",
                "email" => "s$e@g.c",
                "password" => $pw,
                "n_telephone" => "0612345678",
                "code_postal" => "80000",
                "ville" => "Agadir",
                "region" => "ARAreg",
                "adresse" => "N1321 TYPE B SECT N AL MASSIRA AGADIR 80000",
                "niveau" => fake()->randomElement($elems),
                "categorie" => "u6cat",
                "league" => "L1",
            ]);
        }
    }
}
