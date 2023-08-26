<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\fournisseur;
use Illuminate\Http\Request;
use App\Models\ArticleFournisseur;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $categorie = Categorie::findOrFail($request->categorie);

        $numOrdre = Article::where('categorie_id', $categorie->id)->count() + 1;

        $reference = "REF-" . substr($request->libelle, 0, 3) . "-" . str_replace(' ', '', $categorie->libelle) . "-" . $numOrdre;

        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('images', 'public');
            $article = Article::create([
                "libelle" => $request->libelle,
                "categorie_id" => $request->categorie,
                "ref" => $reference,
                "photo" => $imagePath
            ]);
        }else{
            $article = Article::create([
                "libelle" => $request->libelle,
                "categorie_id" => $request->categorie,
                "ref" => $reference,
                // "photo" => $imagePath
            ]);
        }

        $pieces = explode(",", $request->fournisseur);
        // return $pieces;
        foreach ($pieces as $fournisseurId) {

            $fournisseur = fournisseur::find($fournisseurId);
            if ($fournisseur) {
                $prix = $request->prix ?? 0;
                $stock = $request->stock ?? '';
                $date = now();

                $articleFournisseur = ArticleFournisseur::create([
                    'fournisseur_id' => $fournisseurId,
                    'article_id' => $article->id,
                    'prix' => $prix,
                    'stock' => $stock,
                    'date' => $date,
                ]);
            }
        }

        return [
            "message" => "Enregistrement Effectue Avect succes",
            "data" => $article
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $article  = Article::where("id",$request->article_id)->first();
        if ($article) {
            $categorie = Categorie::findOrFail($request->categorie);

            $numOrdre = Article::where('categorie_id', $categorie->id)->count() + 1;

            $reference = "REF-" . substr($request->libelle, 0, 3) . "-" . str_replace(' ', '', $categorie->libelle) . "-" . $numOrdre;

            if ($request->hasFile('photo')) {
                $imagePath = $request->file('photo')->store('images', 'public');
                $article->update([
                    "libelle" => $request->libelle,
                    "categorie_id" => $request->categorie,
                    "photo" => $imagePath,
                    "ref"=> $reference
                ]);
            }else{
                $article->libelle = $request->libelle;
                $article->categorie_id = $request->categorie;
                $article->ref = $reference;
                $article->save();
            }
            $association = ArticleFournisseur::where("id",$request->association_id)->first();
            return $association;
            $association->prix = strval($request->prix);
            $association->stock = $request->stock;
            $association->fournisseur_id = $request->fournisseur;
            $association->save();
            return [
                "message" => "Enregistrement Effectue Avect succes",
                "data" => $association
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article) {
            $articleFournisseur = ArticleFournisseur::where("article_id", $article->id)->delete();

            $etat = $article->delete();
            return [
                'message' => "Suppression d'un seule Categorie Effectue avec Success",
                'etat' => $etat
            ];
        } else {
            return [
                'message' => "Cet article a des dépendances et ne peut pas être supprimé.",
                'etat' => false
            ];
        }
    }

    public function search($art)
    {
        $articles = Article::where('libelle', 'LIKE', "$art%")->get();
        $libAndStock = $articles->map(function ($article) {
            return [
                'libelle' => $article->libelle,
                'stock' => $article->stock,
            ];
        });
        return $libAndStock;
    }
}
