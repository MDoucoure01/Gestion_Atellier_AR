<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\fournisseur;
use Illuminate\Http\Request;
use App\Models\ArticleFournisseur;
use App\Http\Resources\InfoResource;
use App\Http\Requests\CategorieRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\FournisseurResource;
use App\Http\Resources\ArticleFournisseurRessource;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $perPage = $request->query('par_page', 5);
        $categories = Categorie::all();
        $fournisseur = fournisseur::all();
        $article = Article::all();
        // $articleFournisseur = ArticleFournisseur::all();
        $arti = Article::with(['categorie', 'articleFournisseurs'])->get();



        $cat = CategorieResource::collection($categories);
        $four = FournisseurResource::collection($fournisseur);
        $art = ArticleResource::collection($article);
        // $artFour = ArticleFournisseurRessource::collection($articleFournisseur);
        // return $categories;
        return [
            "message" => "Categories disponible",
            "data" => [
                "fournisseur" => $four,
                "categorie" => $cat,
                "article" => $art,
                "association" => InfoResource::collection($arti),
            ]
        ];
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieRequest $request)
    {
        $categorie = Categorie::create(["libelle" => $request->libelle]);
        $catResource = new CategorieResource($categorie);

        return [
            "message" => "Categorie Enregistrer Avec Success",
            "data" => $catResource
        ];
    }


    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategorieRequest $request, Categorie $categorie)
    {
        $categorie->libelle = $request->libelle;
        $categorie->save();
        $cat = new CategorieResource($categorie);
        return [
            "message" => "Mise a jour effectuer avec success Enregistrer Avec Success",
            "date" => $cat
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $unique = $request->query('unique');
        $ids = $request->ids;
        if (!$ids) {
            $categorie = Categorie::find($unique);
            $etat = $categorie->delete();
            return [
                'message' => "Suppression d'un seule Categorie Effectue avec Success",
                'etat' => $etat
            ];
        }

        $etat = Categorie::whereIn('id', $ids)->delete();

        return [
            'message' => "Suppression Effectue avec Success",
            'etat' => $etat
        ];
    }

    public function rechercherCategorie(Request $request)
    {
        $libelle = $request->libelle;
        $categories = Categorie::where('libelle', 'LIKE',$libelle .'%')
        ->first();

        return [
            "message" => "Résultats de la recherche pour le libellé: ' $libelle '",
            "data" => $categories,
        ];
    }

    // public function suppression(Request $request)
    // {
    //     return 'fdhgh';
    //     // $ids = $request->ids;
    //     // return $ids;
    // }
}
