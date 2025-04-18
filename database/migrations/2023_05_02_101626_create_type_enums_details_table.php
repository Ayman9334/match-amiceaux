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
        Schema::create('type_enums_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("type_enum_id")->constrained();
            $table->string("libelle");
            $table->string("code")->unique();
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
        Schema::dropIfExists('type_enums_details');
    }
};
