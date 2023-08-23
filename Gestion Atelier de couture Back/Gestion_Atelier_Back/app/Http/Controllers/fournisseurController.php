<?php

namespace App\Http\Controllers;

use App\Models\fournisseur;
use Illuminate\Http\Request;
use Validator;

class fournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = fournisseur::all();

        // return $categories;
        return [
            "message" => "Categories disponible",
            "data" => $categories
        ];
    }

    public function rechercherFournisseur(Request $request)
    {
        $rechercher = $request->libelle;

        $fournisseurs = Fournisseur::where('nom', 'like',$rechercher . '%')->get();

        return [
            "message" => "Fournissuer trouve",
            "data" => $fournisseurs
        ];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'nom'=> 'required',
        ]);

        if ($validate->fails()) {
            return Response(["message" => $validate->errors()],401);
        }

        $fournisseurExiste = fournisseur::where('nom', $request->nom)->first();

        if ($fournisseurExiste){
            return [
                "message" => "le fournisseur Existe deja",
                "data" => []
        ];
        }

        $fournisseur = fournisseur::create(["nom"=>$request->nom]);

        return [
            "message" => "Enregistrement Effectuer Avec success",
            "data" => $fournisseur
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(fournisseur $fournisseur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, fournisseur $fournisseur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(fournisseur $fournisseur)
    {
        //
    }
}
