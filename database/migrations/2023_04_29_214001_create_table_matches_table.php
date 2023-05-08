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
        Schema::create('table_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisateur_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->dateTime('match_date')->format('Y-m-d H:i');
            $table->string('nembre_joueur');
            $table->string('lieu');
            $table->string('niveau');
            $table->string('categorie');
            $table->string('ligue');
            $table->longText('description');
            $table->foreignId('createur_id')->nullable()->constrained('users');
            $table->foreignId('dernier_editeur_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_matches');
    }
};
