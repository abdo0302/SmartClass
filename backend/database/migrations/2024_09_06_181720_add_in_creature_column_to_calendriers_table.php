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
        Schema::table('calendriers', function (Blueprint $table) {
            $table->unsignedBigInteger('in_creature');
            $table->foreign("in_creature")->references("id")->on("users")->onDelete('cascade');
            $table->unsignedBigInteger('id__session');
            $table->foreign("id__session")->references("id")->on("classes")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('calendriers', function (Blueprint $table) {
            //
        });
    }
};
