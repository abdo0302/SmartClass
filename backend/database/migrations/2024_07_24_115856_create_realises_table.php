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
        Schema::create('realises', function (Blueprint $table) {
            $table->id();
            $table->integer('score');
            $table->unsignedBigInteger("in_user");
            $table->unsignedBigInteger("in_Devoir");
            $table->foreign("in_user")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("in_Devoir")->references("id")->on("devoirs")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realises');
    }
};
