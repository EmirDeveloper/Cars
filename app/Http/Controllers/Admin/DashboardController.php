<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        $modals = [
            ['name' => 'customers', 'total' => Customer::count()],
            ['name' => 'products', 'total' => Product::count()],
            ['name' => 'categories', 'total' => Category::count()],
            ['name' => 'brands', 'total' => Brand::count()],
            ['name' => 'attributes', 'total' => Attribute::count()],
        ];

        return view('admin.dashboard.index')
            ->with([
                'modals' => $modals
            ]);
    }
}
