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
        Schema::create('MasterUser', function(Blueprint $table) {
            $table->uuid('userID')->default(DB::raw('(UUID())'))->primary();
            $table->string('fullname', 255);
            $table->string('position', 255);
            $table->string('email', 255);
            $table->string('password', 70);
            $table->string('picture', 255);
            $table->timestamp('createdAt')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updatedAt')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('MasterUser');
    }
};
