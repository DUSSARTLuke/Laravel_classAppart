<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'numOrder', 'price',
    ];

    public function Products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantite')->withTimestamps();
    }

    public function recupPriceProduct(int $id)
    {

        $priceP = DB::table('products')->where(['id' => $id])->pluck('price')->first();
        return $priceP;
    }
}
