<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with('parent')
            ->firstOrFail();
        $products = Product::where('category_id', $category->id)
            ->with('customer')
            ->orderBy('random')
            ->simplePaginate(24);

        return view('category.show')
            ->with([
                'category' => $category,
                'products' => $products,
            ]);
    }
}
