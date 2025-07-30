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
        Schema::create('dictis', function (Blueprint $table) {
            $table->id();
            $table->string("full_name");
            $table->foreignId("parent_id")->nullable()->constrained("dictis")->onDelete("cascade");
            $table->text("char_value")->nullable();
            $table->float("num_value")->nullable();
            $table->json("json_value")->nullable();
            $table->string("constant")->nullable();
            $table->string("constant1")->nullable();
            $table->string("constant2")->nullable();
            $table->boolean("active")->default(true);
            $table->integer("order_no")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dictis');
    }
};
