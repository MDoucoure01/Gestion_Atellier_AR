<?php

use App\Models\Article;
use App\Models\ArticleVente;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vente_articles', function (Blueprint $table) {
            $table->id();
            $table->float('qte');
            $table->foreignIdFor(Article::class)->constrained();
            $table->foreignIdFor(ArticleVente::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vente_articles');
    }
};
