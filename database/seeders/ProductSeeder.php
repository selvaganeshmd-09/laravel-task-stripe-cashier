<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Stripe\Stripe;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;

class ProductSeeder extends Seeder
{
    public function run()
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $products = Product::factory()->count(5)->create();

        foreach ($products as $product) {

            $stripeProduct = StripeProduct::create([
                'name' => $product->name,
                'description' => $product->description,
                'metadata' => [
                    'product_id' => $product->id,
                    'product_uuid' => $product->uuid
                ],
            ]);

            $stripePrice = StripePrice::create([
                'unit_amount' => $product->price * 100,
                'currency' => 'inr',
                'product' => $stripeProduct->id,
            ]);

            $product->update([
                'stripe_product_id' => $stripeProduct->id,
                'stripe_price_id' => $stripePrice->id,
            ]);

        }
    }
}