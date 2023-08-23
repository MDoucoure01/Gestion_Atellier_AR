<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "libelle" => "required|min:3",
            "prix" => "required",
            "stock" => "required",
            "categorie" => "required|exists:categories,id",
            "fournisseur" => "required|exists:categories,id",
            'photo' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }

    public function messages(): array
    {
        return [
            "libelle.required" => "La saisie du Libelle est requis",
            "libelle.min" => "Le libelle dou contenir Au moin 3 caractéres",
            "prix.required" => "le prix est Obligatoire",
            "stock.required" => "Le stock est obligatoire",
            "categorie.required" => "Categorie Obligatoire",
            "categorie.exists" => "Cette Categorie n'exist pas",
            "fournisseur.exists" => "fournisseur Obligatoire",
            "fournisseur" => "Cette fournisseur n'existe pas",
            "photo.mimes" => "format Invalide",
        ];
    }
}
