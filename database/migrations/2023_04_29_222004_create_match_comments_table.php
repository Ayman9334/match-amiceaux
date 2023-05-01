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
        Schema::create('match_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_membre_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->longText('commentaire');
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
        Schema::dropIfExists('match_comments');
    }
};
