<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Order;

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
    }
}
