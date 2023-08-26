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

    public function article()
    {
        return $this->belongsToMany(Article::class, 'vente_articles', 'article_id', 'article_vente_id');
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
