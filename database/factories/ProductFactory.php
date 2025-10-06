<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('en_US');
        return [
            'name' => $faker->randomElement([
                'Amla Juice', 'Besan (Gram Flour)', 'Bhindi (Okra)', 'Chili Powder',
                'Coriander Seeds', 'Cumin Seeds', 'Ghee (Clarified Butter)', 'Haldi Powder',
                'Idli Rice', 'Instant Mix Dosa', 'Jaggery', 'Karela Chips', 'Khoya',
                'Mango Pickle', 'Masala Chai', 'Milk Powder', 'Paneer Cubes', 'Poha',
                'Rice Flour', 'Rasam Powder', 'Sambar Powder', 'Suji (Semolina)',
                'Tamarind Paste', 'Turmeric Powder', 'Urad Dal', 'Wheat Flour', 'Cardamom Pods',
                'Coconut Oil', 'Ginger Paste', 'Lassi', 'Methi Seeds', 'Mint Chutney',
                'Puffed Rice', 'Ragi Flour', 'Rose Syrup', 'Sattu Powder', 'Semolina Ladoo',
                'Vanilla Essence', 'Vermicelli', 'Yellow Lentils', 'Besan Ladoo', 'Kesar Milk',
            ]),
            'description' => implode("\n", $faker->paragraphs(3)),
            'price' => $faker->numberBetween(500, 5000),
        ];
    }
}
