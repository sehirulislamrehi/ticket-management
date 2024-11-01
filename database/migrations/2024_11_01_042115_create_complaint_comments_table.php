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
        Schema::create('complaint_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("complaint_id");
            $table->unsignedBigInteger("user_id");
            $table->longText("comment");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaint_comments');
    }
};