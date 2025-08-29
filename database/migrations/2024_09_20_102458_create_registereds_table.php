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
        Schema::create('registered', function (Blueprint $table) {
            $table->id();
            $table->integer('links_limit')->default(10);
            $table->integer('page_views')->default(0);
            $table->integer('links_clicks')->default(0);
            $table->boolean("isBlocked")->default(false);
            $table->foreignId("user_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registered');
    }
};
