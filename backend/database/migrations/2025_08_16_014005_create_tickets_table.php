<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('ticket_id');

            $table->unsignedBigInteger('participant_id');
            $table->foreign('participant_id')->references('participant_id')->on('participants')->onDelete('cascade');

            $table->unsignedBigInteger('evenement_id');
            $table->foreign('evenement_id')->references('evenement_id')->on('evenements')->onDelete('cascade');

            $table->enum('type_ticket', ['standard','premium','VIP']);
            $table->decimal('prix', 10, 2);
            $table->integer('stock')->default(0); 
            $table->enum('statut', ['valide','annule','utilise'])->default('valide');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['evenement_id','type_ticket']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
