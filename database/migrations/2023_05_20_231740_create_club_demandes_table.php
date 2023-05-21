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
        Schema::create('club_demandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("utilisateur_id")->unique()->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId("club_id")->constrained("clubs")
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
        Schema::dropIfExists('club_demandes');
    }
};
