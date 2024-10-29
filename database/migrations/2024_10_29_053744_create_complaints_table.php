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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->enum('category', array_map(fn($case) => $case->value, \App\Enum\ComplaintCategoryEnum::cases()))
                ->comment(implode(',', array_map(fn($case) => $case->value, \App\Enum\ComplaintCategoryEnum::cases())));
            $table->enum('priority', array_map(fn($case) => $case->value, \App\Enum\ComplaintPriorityEnum::cases()))
                ->comment(implode(',', array_map(fn($case) => $case->value, \App\Enum\ComplaintPriorityEnum::cases())));
            $table->enum('status', array_map(fn($case) => $case->value, \App\Enum\ComplaintStatusEnum::cases()))
                ->comment(implode(',', array_map(fn($case) => $case->value, \App\Enum\ComplaintStatusEnum::cases())));
            $table->string("image")->nullable();
            $table->unsignedBigInteger("created_by");
            $table->date("submission_date");
            $table->date("resolved_at")->nullable();
            $table->string("time_taken")->default(0)->comment("value stored in sec.");
            $table->string("day_taken")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
