<?php

// database/migrations/2025_08_22_000000_create_paiements_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('paiements', function (Blueprint $table) {
            $table->bigIncrements('paiement_id');
            $table->unsignedBigInteger('user_id');        // l’acheteur (participant user)
            $table->decimal('montant', 10, 2);
            $table->enum('methode', ['bank','mobile_money','carte']);
            $table->string('provider')->nullable();       // mtn, moov, stripe...
            $table->string('reference', 150)->unique();   // ref opérateur (ou générée)
            $table->string('currency', 10)->default('XOF');
            $table->enum('statut', ['reussi','echoue','en_attente','refund'])->default('en_attente');
            $table->json('meta')->nullable();             // payload opérateur
            $table->timestamp('refunded_at')->nullable();
            $table->decimal('montant_refund', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'statut']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('paiements');
    }
};
