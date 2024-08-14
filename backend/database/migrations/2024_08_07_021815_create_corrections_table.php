<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('corrections', function (Blueprint $table) {
            $table->id();
            $table->integer('score');
            $table->string('description');
            $table->string('file');
            $table->unsignedBigInteger('id_reponse');
            $table->unsignedBigInteger('id_question');
            $table->unsignedBigInteger('id_professeur');
            $table->foreign("id_reponse")->references("id")->on("reponses")->onDelete('cascade');
            $table->foreign("id_question")->references("id")->on("question_media_integres")->onDelete('cascade');
            $table->foreign("id_professeur")->references("id")->on("users")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corrections');
    }
};
