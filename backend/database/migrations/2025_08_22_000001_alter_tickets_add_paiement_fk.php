<?php

// database/migrations/2025_08_22_000001_alter_tickets_add_paiement_fk.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('paiement_id')->nullable()->after('prix');
            $table->string('ticket_code', 64)->unique()->after('paiement_id'); // pour QR
            $table->enum('statut', ['valide','annule','utilise'])->default('valide')->change();

            $table->foreign('paiement_id')->references('paiement_id')->on('paiements')->nullOnDelete();
            $table->index(['evenement_id', 'statut']);
        });
    }
    public function down(): void {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['paiement_id']);
            $table->dropColumn(['paiement_id', 'ticket_code']);
        });
    }
};
