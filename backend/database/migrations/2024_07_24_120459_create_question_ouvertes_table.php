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
        Schema::create('question_ouvertes', function (Blueprint $table) {
            $table->id();
            // $table->string('question');
            // $table->string('type');
            // $table->unsignedBigInteger("in_creature");
            // $table->unsignedBigInteger("in_devoir");
            // $table->foreign("in_creature")->references("id")->on("users");
            // $table->foreign("in_devoir")->references("id")->on("devoirs");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_ouvertes');
    }
};
