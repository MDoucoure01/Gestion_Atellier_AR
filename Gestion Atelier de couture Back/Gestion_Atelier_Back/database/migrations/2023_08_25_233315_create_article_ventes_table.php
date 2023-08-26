<?php

use App\Models\Categorie;
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
        Schema::create('article_ventes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('libelle')->unique();
            $table->float('qteStock');
            $table->float('promo')->nullable();
            $table->string('ref')->unique();
            $table->float('cout');
            $table->string('marge')->nullable();
            $table->float('prix_vente');
            $table->string('photo')->nullable();
            $table->foreignIdFor(Categorie::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_ventes');
    }
};
