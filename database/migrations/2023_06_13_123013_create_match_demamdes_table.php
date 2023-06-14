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
        Schema::create('match_demamdes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('match_id')->constrained('table_matches')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('invitation_type');
            $table->foreignId('candidat_invite_id')->nullable()->constrained('club_membre')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_demamdes');
    }
};
