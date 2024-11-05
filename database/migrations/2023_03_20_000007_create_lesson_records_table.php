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
        Schema::create('lesson_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('student_id');
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->text('teacher_comment')->nullable(); // 講師コメント
            $table->text('school_memo')->nullable(); // スクール用のメモ
            $table->text('video')->nullable();
            $table->date('lesson_date');
            $table->string('post_status', 100)->default('draft');
            $table->timestamps();
            
            // 外部キー制約
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_records');
    }
};
