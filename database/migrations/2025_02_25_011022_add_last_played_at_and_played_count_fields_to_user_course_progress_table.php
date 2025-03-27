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
        Schema::table('user_course_progress', function (Blueprint $table) {
            $table->integer('played_count')->default(0)->after('is_completed');
            $table->dateTime('last_played_at')->nullable()->after('is_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_course_progress', function (Blueprint $table) {
            $table->dropColumn([
                'played_count',
                'last_played_at'
            ]);
        });
    }
};
