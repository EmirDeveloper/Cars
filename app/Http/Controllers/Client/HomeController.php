<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Home;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort_order')
            ->with('parent', 'products')
            ->get();

        return view('client.home.index')
            ->with([
                'categories' => $categories
            ]);
    }
}
