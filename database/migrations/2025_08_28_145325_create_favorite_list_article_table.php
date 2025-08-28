<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('favorite_list_article', function (Blueprint $table) {
            $table->id();
            $table->foreignId('favorite_list_id')->constrained()->onDelete('cascade');
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['favorite_list_id', 'article_id']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('favorite_list_article');
    }
};

