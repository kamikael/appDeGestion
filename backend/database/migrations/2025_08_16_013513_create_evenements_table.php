<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id('evenement_id');

            $table->unsignedBigInteger('createur_id');
            $table->foreign('createur_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('nom', 150);
            $table->text('description');
            $table->string('categorie', 100);
            $table->string('lieu', 255);
            $table->dateTime('date_debut');
            $table->dateTime('date_fin');
            $table->string('image', 255);
            $table->string('video', 255)->nullable();
            $table->decimal('prix_standard', 10, 2)->default(0);
            $table->decimal('prix_premium', 10, 2)->nullable();
            $table->decimal('prix_vip', 10, 2)->nullable();
            $table->enum('statut', ['en_attente','approuve','refuse','termine'])->default('en_attente');
            $table->integer('tickets_vendus')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};
