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
        Schema::create('damage_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId("damage_note_id")->constrained("damage_notes")->cascadeOnDelete();
            $table->text("filepath");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_images');
    }
};
