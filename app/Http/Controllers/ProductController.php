<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Stripe\Stripe;
use Laravel\Cashier\Cashier;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        if(!auth()->check()){
            return redirect()->route('login')->with('info', 'Please login or register to buy this product.');
        }

        return view('products.show', compact('product'));
    }
}