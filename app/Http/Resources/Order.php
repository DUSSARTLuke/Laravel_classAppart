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

        return [
            'numOrder' => $this->numOrder,
            'product' => DB::table('order_products')->where(['order_id' => $this->id])->get(['product_id', 'quantite']),
            'price' => $this->price
        ];
    }
}
