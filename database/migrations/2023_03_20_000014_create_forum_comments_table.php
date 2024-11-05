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
        Schema::create('forum_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('forum_id');
            $table->unsignedBigInteger('parent_comment_id')->nullable();
            $table->unsignedBigInteger('mentioned_user_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->text('body');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade');
            $table->foreign('parent_comment_id')->references('id')->on('forum_comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_comments');
    }
};
