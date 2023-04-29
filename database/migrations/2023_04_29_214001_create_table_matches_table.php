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
            $table->date('match_date');
            $table->string('lieu');
            $table->string('niveau');
            $table->string('categorie');
            $table->string('ligue');
            $table->longText('description');
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
