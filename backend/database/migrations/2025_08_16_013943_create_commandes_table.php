<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id('commande_id');

            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');

            $table->unsignedBigInteger('produit_id');
            $table->foreign('produit_id')->references('produit_id')->on('produits')->onDelete('restrict');

            $table->integer('quantite');
            $table->decimal('prix_total', 10, 2);
            $table->enum('statut', ['en_attente','payee','annulee','livree'])->default('en_attente');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['participant_id','statut']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
