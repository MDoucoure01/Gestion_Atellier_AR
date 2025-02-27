<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\ArticleVente;
use App\Models\VenteArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\VenteArticleResource;
use App\Http\Requests\StoreArticleVenteRequest;
use App\Http\Resources\ArticleVenteArticleResource;

class VenteArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = ArticleVente::all();
        $categorie = Categorie::all();
        $article = Article::all();
        return response()->json([
            "message" => "Tous les articles de ventes",
            'data'=>
            [
                'articlesVentes' => VenteArticleResource::collection($articles),
                'categorie' => CategorieResource::collection($categorie),
                'article_confection' => ArticleVenteArticleResource::collection($article)
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $article = new ArticleVente();
            $cat = Categorie::where('id', $request->categorie_id)->first();
            if (!$cat) {
                throw new \Exception('Catégorie introuvable');
            }

            $categorie = Categorie::findOrFail($request->categorie_id);

            $numOrdre = Article::where('categorie_id', $categorie->id)->count() + 1;

            $reference = "REF-" . substr($request->libelle, 0, 3) . "-" . str_replace(' ', '', $categorie->libelle) . "-" . $numOrdre;
            $cout = 0;

            foreach ($request->confectionArticles as $key) {
                $article = Article::where('libelle', $key['id'])->first();
                $cout += ($article->prix * $key['qte']);
            }
            $prix = $cout+$request->marge;

            $article = ArticleVente::create([
                "libelle" => $request->libelle,
                "categorie_id" => $request->categorie_id,
                "ref" => $reference,
                "cout" => $cout,
                "prix_vente" => $prix,
                "marge" => $request->marge,
                "qteStock" => 10,
                "promo" => $request->promo
            ]);

            foreach ($request->confectionArticles as $key) {
                $articleCon = Article::where('libelle', $key['id'])->first();
                $association = VenteArticle::create([
                    "qte" =>$key['qte'],
                    "article_id" => $articleCon->id,
                    "article_vente_id" => $article->id,
                ]);
            }

            return [
                "message" => "enregistrement effectuer",
                "data" => new VenteArticleResource($article)
            ];

        });
    }

    /**
     * Display the specified resource.
     */
    public function show(VenteArticle $venteArticle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VenteArticle $venteArticle)
    {
        $article = ArticleVente::find($request->id);
        $article->libelle = $request->libelle;
        $article->categorie_id = $request->categorie_id;
        $article->marge = $request->marge;
        $article->qteStock = $request->stock;
        if ($request->photo) {
            $article->photo = $request->photo;
        }
        if ($request->promo) {
            $article->promo = $request->promo;
        }

        $article->save();

        if (count($request->article) < 3 ) {
            return response()->json(['message' => 'Articles de confection fournis insuffisants'], 400);
        }

        foreach ($request->article as $key) {
            $association = VenteArticle::where("article_vente_id",$article->id)->first();
            $association->qte = $key['quantity'];
            $association->article_id = $key['id'];
            $association->article_vente_id = $article->id;
        }

        return [
            "message" => "enregistrement effectuer",
            "data" => new VenteArticleResource($article)
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return DB::transaction(function () use ($request) {
            DB::table('vente_articles')->where('article_vente_id', $request->id)->delete();

            $article = ArticleVente::findOrFail($request->id);
            $article->delete();

            return response()->json([
                'message' => 'Article supprimé avec succès',
                'status' => 200
            ]);
        });
    }

}
