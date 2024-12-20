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
        Schema::create('sinscrits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("in_eleve");
            $table->unsignedBigInteger("in_classe");
            $table->foreign("in_eleve")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("in_classe")->references("id")->on("classes")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinscrits');
    }
};
