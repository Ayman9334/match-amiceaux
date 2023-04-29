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
        Schema::create('match_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('table_matches')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('media');
            $table->string('media_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_media');
    }
};
