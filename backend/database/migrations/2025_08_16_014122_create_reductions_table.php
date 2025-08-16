<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reductions', function (Blueprint $table) {
            $table->id('reduction_id');
            $table->string('code', 50)->unique();
            $table->enum('type_cible', ['ticket','produit']);
            $table->decimal('valeur', 10, 2);
            $table->boolean('pourcentage')->default(false);
            $table->dateTime('date_debut');
            $table->dateTime('date_fin')->nullable();
            $table->enum('statut', ['actif','expire','inactif'])->default('actif');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['type_cible','statut']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('reductions');
    }
};
