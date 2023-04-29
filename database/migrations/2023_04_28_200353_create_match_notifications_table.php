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
        Schema::create('match_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('lieu');
            $table->string('niveau');
            $table->string('categorie');
            $table->string('ligue');
            $table->integer('zone_chalandise');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_notifications');
    }
};
