<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('club_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId("member_id")->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId("club_id")->constrained("clubs")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string("member_role");
            $table->timestamps();
        });
        DB::statement('ALTER TABLE club_members
            ADD CHECK (member_role IN ("proprietaire","coproprietaire","member"))
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_members');
    }
};
