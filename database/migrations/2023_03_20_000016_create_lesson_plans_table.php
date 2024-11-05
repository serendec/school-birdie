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
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->string('name');
            $table->string('price')->nullable();
            $table->tinyInteger('video_advice_available')->nullable();
            $table->integer('video_advice_num')->nullable();
            $table->integer('video_advice_automatically_close_period')->nullable();
            $table->tinyInteger('course_available')->nullable();
            $table->tinyInteger('lesson_record_available')->nullable();
            $table->tinyInteger('forum_available')->nullable();
            $table->timestamps();
            
            // 外部キー制約
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
