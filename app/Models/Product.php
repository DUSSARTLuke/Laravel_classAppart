<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle', 'slug', 'description', 'price'
    ];

    public function Orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
