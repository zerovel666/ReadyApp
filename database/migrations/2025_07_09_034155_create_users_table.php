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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("email")->unique();
            $table->string('full_name');
            $table->foreignId("country_id")->nullable()->constrained("countries")->onDelete("cascade");
            $table->foreignId("partner_id")->nullable()->constrained("partners")->onDelete("cascade");
            $table->foreignId("telegram_user_id")->nullable();
            $table->string("uniq_id_people")->nullable()->unique();
            $table->string("phone")->unique();
            $table->boolean("active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
