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
            $table->dateTime('clockedIn')->nullable();
            $table->dateTime('clockedOut')->nullable();
            $table->text('activity');
            $table->char('longitudeIn', 70)->nullable();
            $table->char('latitudeIn', 70)->nullable();
            $table->char('longitudeOut', 70)->nullable();
            $table->char('latitudeOut', 70)->nullable();
            $table->string('pictureIn', 255)->nullable();
            $table->string('pictureOut', 255)->nullable();
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
