<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jeux', function (Blueprint $table) {
            $table->id('jeu_id');

            $table->unsignedBigInteger('evenement_id');
            $table->foreign('evenement_id')->references('evenement_id')->on('evenements')->onDelete('cascade');

            $table->enum('type', ['physique','virtuel']);
            $table->string('nom', 150);
            $table->string('image', 255)->nullable();
            $table->text('description');
            $table->string('recompense', 150);
            $table->enum('statut', ['actif','inactif'])->default('actif');

            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('jeux');
    }
};
