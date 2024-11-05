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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('video')->nullable();
            $table->integer('video_duration')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('school_id');
            $table->string('post_status', 100)->default('draft');
            $table->integer('display_order')->length(5);
            $table->timestamps();

            // 外部キー制約
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            // $table->foreign('category_id')->references('id')->on('course_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
