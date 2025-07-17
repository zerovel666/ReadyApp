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
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId("creator")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("stamp")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("body")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("engine")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("transmission")->constrained("dictis")->onDelete("cascade");
            $table->float("engine_volume");
            $table->integer("power");
            $table->integer("seats");
            $table->integer("doors");
            $table->float("fuel_tank_capacity");
            $table->integer("weight");
            $table->float("height");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_models');
    }
};
