<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Liior\Faker\Prices($faker));
        \Bezhanov\Faker\ProviderCollectionHelper::addAllProvidersTo($faker);
        for ($i = 1; $i <= 30; $i++) {
            Order::create([
                'numOrder' => $faker->bothify('ORD####????'),
            ]);
        }
        $product_ids = Product::all()->pluck('id')->toArray();
        $order_ids = Order::all()->pluck('id')->toArray();


        for ($i = 1; $i < count($order_ids) + 1; $i++) {
            $price = 0;
            $order = Order::findorFail($i);
            for ($j = 0; $j < $faker->numberBetween(1, 10); $j++) {
                $prod_id = $faker->randomElement($product_ids);
                $quantite = $faker->numberBetween(1, 10);
                OrderProduct::create([
                    'order_id' => $i,
                    'product_id' => $prod_id,
                    'quantite' => $quantite,
                ]);
                $price += $order->recupPriceProduct($prod_id) * $quantite;
            }
            $order->price = $price;
            $order->save();
        }
        
    }
}
