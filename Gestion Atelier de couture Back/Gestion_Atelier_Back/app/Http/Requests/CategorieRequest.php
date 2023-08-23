<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
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
            "libelle" => "required|min:3|unique:categories",
        ];
    }

    public function messages(): array
    {
        return [
            "libelle.required" => "La saisie du Libelle est requis",
            "libelle.unique" => "Le Libelle que vous Avez Saisie Existe déja",
            "libelle.min" => "Le libelle dou contenir Au moin 3 caractéres"
        ];
    }
}
