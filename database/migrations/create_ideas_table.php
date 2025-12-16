<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('product.ideas_table', 'ideas'), function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('importance')->default('not_important');
            $table->text('context')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('reactions_count')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'created_at']);
            $table->index('importance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('product.ideas_table', 'ideas'));
    }
};
