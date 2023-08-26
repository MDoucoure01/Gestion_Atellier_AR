<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'categorie_id' => $this->categorie_id,
            'categories' => $this->categorie->libelle,
            'photo' => $this->photo,
            'referrence' => $this->ref,
            'stock' => $this->stock,
            'prix' => $this->prix,
        ];
    }
}
