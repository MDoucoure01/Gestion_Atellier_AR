<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteArticle extends Model
{
    use HasFactory;

    protected $guarded = [
        "id"
    ];

    // protected static function boot()
    // {
    //     // parent::boot();

    //     // static::created(function ($articleVente) {
    //     //     foreach ($articleVente->confectionArticles as $confectionItem) {
    //     //         $article = Article::where('libelle', $confectionItem['id'])->first();

    //     //         if ($article) {
    //     //             $articleVente->articles()->attach($article->id, ['quantity' => $confectionItem['qte']]);
    //     //         }
    //     //     }
    //     // });
    // }


    public function article()
    {
        return $this->belongsToMany(Article::class, 'vente_articles', 'article_id', 'article_vente_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
