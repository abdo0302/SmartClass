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
            $table->string('description');
            $table->string('file');
            $table->string('typ_file');
            $table->date('date_creation');
            $table->unsignedBigInteger("in_creature");
            $table->unsignedBigInteger("in_classe");
            $table->foreign("in_creature")->references("id")->on("users");
            $table->foreign("in_classe")->references("id")->on("classes");
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
