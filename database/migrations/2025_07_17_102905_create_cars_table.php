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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId("model_id")->constrained("car_models")->cascadeOnDelete();
            $table->foreignId("partner_id")->constrained("partners")->cascadeOnDelete();
            $table->string("vin");
            $table->string("license_plate");
            $table->foreignId("color_id")->constrained("dictis")->cascadeOnDelete();
            $table->float("mileage");
            $table->date("last_inspection_date");
            $table->date("date_release");
            $table->float("rating");
            $table->foreignId("status")->constrained('dictis')->cascadeOnDelete();
            $table->float("amount");
            $table->foreignId("currency_id")->constrained('dictis')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
