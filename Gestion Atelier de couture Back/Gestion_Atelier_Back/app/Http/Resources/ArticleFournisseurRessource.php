<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleFournisseurRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return  [
        "id" => $this->id,
        "stock" => $this->stock,
        "date" => $this->data,
        "prix" => $this->prix,
        "fournisseur_id" => $this->fournisseur_id,
        "article_id" => $this->article_id,
        ];
    }
}
