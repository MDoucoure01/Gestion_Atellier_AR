<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\fournisseurController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/categorie',CategorieController::class)->only(['index','store','update','destroy']);
Route::post('/categorie/recherche',[CategorieController::class,"rechercherCategorie"]);
Route::delete('suppression',[CategorieController::class,"destroy"]);


Route::apiResource('fournisseur',fournisseurController::class)->only(['index','store','update','destroy']);


Route::apiResource('article',ArticleController::class)->only(['index','store','destroy']);


Route::post('/fournisseur/recherche',[fournisseurController::class,"rechercherFournisseur"]);

Route::post('article/modifier',[ArticleController::class,"update"]);
