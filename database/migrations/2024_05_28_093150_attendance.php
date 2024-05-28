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
        Schema::dropIfExists('Attendance');
        Schema::create('Attendance', function(Blueprint $table) {
            $table->uuid('attendanceID')->default(DB::raw('(UUID())'))->primary();
            $table->char('userID', 36);
            $table->dateTime('clockedIn');
            $table->dateTime('clockedOut');
            $table->text('activity');
            $table->char('longitude', 70);
            $table->char('latitude', 70);
            $table->string('picture', 255);
            $table->tinyInteger('condition');
            $table->timestamp('createdAt')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updatedAt')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('userID')->references('userID')->on('MasterUser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('Attendance');
    }
};
