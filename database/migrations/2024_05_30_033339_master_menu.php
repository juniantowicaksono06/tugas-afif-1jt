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
        Schema::dropIfExists('MasterMenu');
        Schema::create('MasterMenu', function(Blueprint $table) {
            $table->uuid('menuID')->default(DB::raw('(UUID())'))->primary();
            $table->string('name', 100);
            $table->string('link', 255);
            $table->string('icon', 100);
            $table->tinyInteger('isParent');
            $table->tinyInteger('hasChild');
            $table->uuid('parentID');
            $table->timestamp('createdAt')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updatedAt')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->foreign('parentID')->references('menuID')->on('MasterMenu')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('MasterMenu');
    }
};
