<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Home;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $new = Product::where('created_at', '>=', Carbon::today()->subMonth()->toDateString())
            ->with(['category:id,name_tm,name_en','location:id,name_tm,name_en'])
            ->inRandomOrder()
            ->take(20)
            ->get([
                'id', 'category_id', 'location_id', 'name_tm', 'slug', 'price', 'credit', 'swap', 'created_at'
            ]);

        return view('client.home.index', [
            'new' => $new,
        ]);
    }
}
