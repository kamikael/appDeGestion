<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id('participant_id');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('evenement_id');
            $table->foreign('evenement_id')->references('evenement_id')->on('evenements')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id','evenement_id']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
