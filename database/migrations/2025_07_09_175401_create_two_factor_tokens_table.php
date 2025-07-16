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
        Schema::create('two_factor_tokens', function (Blueprint $table) {
            $table->id();
            $table->string("email");
            $table->json("register_data");
            $table->string("two_factor_code");
            $table->timestamp('code_expires_at');
            $table->boolean("active")->default(true);
            $table->uuid("uuid");
            $table->bigInteger("telegram_chat_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('two_factor_tokens');
    }
};
