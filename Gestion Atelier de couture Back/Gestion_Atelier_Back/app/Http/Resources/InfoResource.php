<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InfoResource extends JsonResource
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
            'photo' => $this->photo,
            'ref' => $this->ref,
            'categorie' => new CategorieResource($this->whenLoaded('categorie')),
            'article_fournisseurs' => ArticleFournisseurRessource::collection($this->whenLoaded('articleFournisseurs')),
        ];
    }
}
