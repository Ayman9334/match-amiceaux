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
            $table->string('nom');
            $table->string('logo')->default('/images/default_image.png');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('n_telephone');
            $table->string('code_postal');
            $table->string('ville');
            $table->string('region');
            $table->string('adresse');
            $table->string('niveau');
            $table->string('categorie');
            $table->string('league');
            $table->string('role')->default('utilisatuer');
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
