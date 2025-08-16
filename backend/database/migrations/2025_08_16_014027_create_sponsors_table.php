<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->id('sponsor_id');

            $table->unsignedBigInteger('evenement_id');
            $table->foreign('evenement_id')->references('evenement_id')->on('evenements')->onDelete('cascade');

            $table->string('nom', 150);
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->string('video', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sponsors');
    }
};
