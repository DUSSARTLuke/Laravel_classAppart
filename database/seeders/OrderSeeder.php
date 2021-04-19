<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

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
                'numOrder' => "0000000000" + $i,
            ]);
        }
        $product_ids = Product::all()->pluck('id')->toArray();
        $order_ids = Order::all()->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            OrderProduct::create([
                'order_id' => $faker->randomElement($order_ids),
                'product_id' => $faker->randomElement($product_ids),
                'quantité' => $faker->numberBetween(1, 10),
            ]);
        }
        for ($i = 1; $i <= count($order_ids); $i++) {
            $orderProd = OrderProduct::where(['order_id', $i]);
            $prix = $orderProd->
            $order->update()
        }
    }
}
