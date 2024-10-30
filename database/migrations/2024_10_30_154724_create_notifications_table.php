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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("from_user_id");
            $table->unsignedBigInteger("to_user_id");
            $table->longText("message");
            $table->boolean("is_viewed");
            $table->text("link")->nullable();
            $table->timestamps();

            $table->foreign("from_user_id")->references("id")->on("users")->onDelete("restrict");
            $table->foreign("to_user_id")->references("id")->on("users")->onDelete("restrict");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
