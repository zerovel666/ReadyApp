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
        Schema::create('agent_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users");
            $table->foreignId("status_id")->constrained("dictis");
            $table->foreignId("schedule_work_id")->constrained("dictis");
            $table->integer("count_сompleted_tasks")->nullable();
            $table->float("rating")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_infos');
    }
};
