<?php

use App\Models\Article;
use App\Models\fournisseur;
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
        Schema::create('article_fournisseurs', function (Blueprint $table) {
            $table->id();
            $table->decimal('prix')->default(0);
            $table->string('stock');
            $table->date('date');
            $table->foreignIdFor(fournisseur::class)->constrained();
            $table->foreignIdFor(Article::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_fournisseurs');
    }
};
