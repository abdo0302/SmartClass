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
        Schema::create('voirs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("in_user");
            $table->unsignedBigInteger("in_contenu");
            $table->foreign("in_user")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("in_contenu")->references("id")->on("contenus")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voirs');
    }
};
