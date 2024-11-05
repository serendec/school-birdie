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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('family_name');
            $table->string('first_name');
            $table->string('family_name_kana');
            $table->string('first_name_kana');
            $table->string('nickname')->nullable();
            $table->string('icon')->nullable();
            $table->string('tel', 13);
            $table->string('email')->unique();
            $table->string('line_id')->nullable();
            $table->string('role');
            $table->unsignedBigInteger('school_id');
            $table->tinyInteger('active')->default(1);
            $table->string('register_student_token')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
