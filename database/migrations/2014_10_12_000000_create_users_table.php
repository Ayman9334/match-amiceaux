<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //info perso
            $table->string('nom');
            $table->string('logo');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('n_telephone');
            //Adress
            $table->string('ville');
            $table->string('code_postal');
            $table->string('region');
            $table->string('adresse');
            //niveau
            $table->string('niveau');
            $table->string('categorie');
            $table->string('league');
            $table->string('role')->nullable();
            //
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
