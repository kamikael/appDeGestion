<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stands', function (Blueprint $table) {
            $table->id('stand_id');

            $table->unsignedBigInteger('entrepreneur_id');
            $table->foreign('entrepreneur_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('evenement_id');
            $table->foreign('evenement_id')->references('evenement_id')->on('evenements')->onDelete('cascade');

            $table->string('nom', 150);
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('est_vedette')->default(false);
             $table->enum('statut', ['en_attente', 'pre_approve', 'approuve', 'refuse'])->default('en_attente');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['evenement_id','statut']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('stands');
    }
};
