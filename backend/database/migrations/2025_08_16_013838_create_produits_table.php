<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id('produit_id');

            $table->unsignedBigInteger('stand_id');
            $table->foreign('stand_id')->references('stand_id')->on('stands')->onDelete('cascade');

            $table->string('nom', 150);
            $table->text('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->integer('stock')->default(0);
            $table->string('image', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['stand_id','nom']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
