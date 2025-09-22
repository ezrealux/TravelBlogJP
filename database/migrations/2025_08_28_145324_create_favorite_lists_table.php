<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('favorite_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(false)->after('description');
            $table->timestamps();
            $table->unsignedInteger('articles_count')->default(0);
        });
    }

    public function down(): void {
        Schema::dropIfExists('favorite_lists');
    }
};
