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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("agent_id");
            $table->foreignId("type_id")->constrained("dictis");
            $table->string("address_a")->nullable();
            $table->string("address_b")->nullable();
            $table->dateTime("date_time_complete");
            $table->foreignId("check_list_id")->nullable()->constrained("dictis");
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
