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
        Schema::create('rencontres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipe_domicile_id')->constrained('equipes')->onDelete('cascade');
            $table->foreignId('equipe_exterieur_id')->constrained('equipes')->onDelete('cascade');
            $table->integer('score_domicile')->nullable();
            $table->integer('score_exterieur')->nullable();
            $table->date('date');
            $table->time('heure');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencontres');
    }
};
