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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("car_id")->constrained("cars")->cascadeOnDelete();
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->foreignId("agent_id")->nullable()->constrained("agent_infos")->cascadeOnDelete();
            $table->dateTime("start_date");
            $table->dateTime("end_date");
            $table->string("latitude");  
            $table->string("longitude");
            $table->enum("status",["pending","approved","completed","canceled"]);
            $table->boolean("notified")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
