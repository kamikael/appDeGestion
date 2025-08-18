<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id('paiement_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->decimal('montant', 10, 2);
            $table->enum('methode', ['bank','mobile_money','carte']);
            $table->string('reference', 150);
            $table->enum('statut', ['reussi','echoue','en_attente'])->default('en_attente');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id','statut','methode']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
