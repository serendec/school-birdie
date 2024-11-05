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
        Schema::create('lesson_record_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_record_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('lesson_record_id')->references('id')->on('lesson_records')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_record_tag');
    }
};
