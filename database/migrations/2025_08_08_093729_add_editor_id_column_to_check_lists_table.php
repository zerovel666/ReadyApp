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
        Schema::table('check_lists', function (Blueprint $table) {
            $table->foreignId("editor_id")->nullable()->constrained("dictis")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('check_lists', function (Blueprint $table) {
            $table->dropColumn("editor_id");
        });
    }
};
