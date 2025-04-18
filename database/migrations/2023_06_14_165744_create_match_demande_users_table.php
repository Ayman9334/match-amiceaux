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
        Schema::create('match_demande_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('club_member_id')->constrained('club_members')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('match_demamde_id')->constrained('match_demamdes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('match_demande_users');
    }
};
