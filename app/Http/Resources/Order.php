<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $moisFr = [
            'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre',
            'novembre', 'décembre'
        ];

        list($jour, $mois, $annee) = explode('/', date("d/n/Y", strtotime($this->created_at)));

        $data =  [
            'id' => $this->id,
            'numOrder' => $this->numOrder,
            'product' => DB::table('order_products')->where(['order_id' => $this->id])->get(['product_id', 'quantite']),
            'price' => $this->price,
            'quantites' => 0,
            'produits' => [],
            'date_commande' => $jour . ' ' . $moisFr[$mois] . ' ' . $annee,
        ];

        foreach ($data['product'] as $prod) {
            $data['quantites'] += $prod->quantite;
            array_push($data['produits'], DB::table('products')->where(['id' => $prod->product_id])->get(['libelle', 'description', 'price']));
        }
        return $data;
    }
}
