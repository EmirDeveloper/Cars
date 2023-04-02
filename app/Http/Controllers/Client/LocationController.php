<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Product;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // public function show($slug)
    // {
    //     $location = Location::where('slug', $slug)
    //         ->with('parent')
    //         ->firstOrFail();
    //     $products = Product::where('location_id', $location->id)
    //         ->simplePaginate(24);

    //     return view('client.product.index')
    //         ->with([
    //             'location' => $location,
    //             'products' => $products,
    //         ]);
    // }
}
