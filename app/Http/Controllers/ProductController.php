<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function allProducts()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function productsByCategory($category_id)
    {
        $products = Product::where('category_id', $category_id)->get();
        $categories = Category::all();
        $selectedCategory = Category::find($category_id);

        return view('products.category', compact('products', 'categories', 'selectedCategory'));
    }
}