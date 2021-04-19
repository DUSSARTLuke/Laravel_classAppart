<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\models\Product;

class ProductSeeder extends Seeder
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
        for ($i = 0; $i < 50; $i++) {
            Product::create([
                'libelle' => $faker->productName(),
                'description' => $faker->sentence(6),
                'price' => $faker->price(0, 150, true)
            ]);
        }
    }
}
