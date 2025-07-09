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
            $table->string("email");
            $table->text("password");
            $table->string("first_name");
            $table->string("parent_name");
            $table->string("last_name");
            $table->string('full_name');
            $table->foreignId("country_id")->nullable()->constrained("countries")->onDelete("cascade");
            $table->string("uniq_id_people")->unique();
            $table->foreignId("partner_id")->nullable()->constrained("partners")->onDelete("cascade");
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
