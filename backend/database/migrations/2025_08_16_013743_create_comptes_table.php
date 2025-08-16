<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comptes', function (Blueprint $table) {
            $table->id('compte_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');

            $table->enum('type_paiement', ['bank','mobile_money']);
            $table->string('numero_compte', 100);
            $table->string('nom_beneficiaire', 150);
            $table->string('banque', 150)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'type_paiement']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};
