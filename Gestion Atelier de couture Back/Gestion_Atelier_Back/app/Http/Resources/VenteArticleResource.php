<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VenteArticleResource extends JsonResource
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

                "id" => $this->id,
                "libelle" => $this->libelle,
                "categorie_id" => $this->categorie_id,
                "categorie" => $this->categorie,
                "reference" => $this->ref,
                "marge" => $this->marge,
                "promo" => $this->promo,
                "cout" => $this->cout,
                "stock" => $this->stock,
                "photo" => $this->photo,
                "qteStock" => $this->qteStock,
                "cout" => $this->cout,
                "prix_vente" => $this->prix_vente,
                // "article" => ArticleConfectionResource::collection($this->articlesConfection)


        ];
    }
}
