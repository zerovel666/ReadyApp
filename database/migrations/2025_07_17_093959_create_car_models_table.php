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
            $table->string("name");
            $table->foreignId("brand_id")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("stamp_id")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("body_id")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("engine_id")->constrained("dictis")->onDelete("cascade");
            $table->foreignId("transmission_id")->constrained("dictis")->onDelete("cascade");
            $table->float("engine_volume");
            $table->integer("power");
            $table->integer("seats");
            $table->integer("doors");
            $table->float("fuel_tank_capacity");
            $table->integer("weight");
            $table->float("height");
            $table->boolean("active")->default(false);
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
