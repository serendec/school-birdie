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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tel', 13)->nullable();
            $table->text('tel_available_time')->nullable();
            $table->string('email')->nullable();
            $table->text('url')->nullable();
            $table->string('icon')->nullable();
            $table->string('top_img')->nullable();
            $table->string('register_teacher_token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
