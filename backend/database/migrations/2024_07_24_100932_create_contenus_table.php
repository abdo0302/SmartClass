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
        Schema::create('contenus', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('description')->nullable();
            $table->string('file');
            $table->string('typ_file');
            $table->unsignedBigInteger("in_creature");
            $table->unsignedBigInteger("in_classe");
            $table->foreign("in_creature")->references("id")->on("users")->onDelete('cascade');
            $table->foreign("in_classe")->references("id")->on("classes")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contenus');
    }
};
