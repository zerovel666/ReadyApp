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
        Schema::create('check_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained("tasks");
            $table->text("field_name");
            $table->integer("order_no");
            $table->boolean("damaged")->nullable()->default(null);
            $table->boolean("cheking")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_lists');
    }
};
