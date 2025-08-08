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
    Schema::create('damage_notes', function (Blueprint $table) {
        $table->id();
        $table->foreignId("car_id")->constrained("cars")->cascadeOnDelete();
        $table->foreignId("task_id")->constrained("tasks")->cascadeOnDelete();
        $table->foreignId("check_list_item_id")->constrained("check_lists")->cascadeOnDelete();
        $table->string('longitude');
        $table->string('latitude');
        $table->boolean('is_resolved')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_notes');
    }
};
