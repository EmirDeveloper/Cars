<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) 
    {
        $request->validate([
            'q' => 'nullable|string|max:255',

            'u' => 'nullable|array',
            'u.*' => 'nullable|integer|min:0|distinct',

            'c' => 'nullable|array',
            'c.*' => 'nullable|integer|min:0|distinct',

            'b' => 'nullable|array',
            'b.*' => 'nullable|integer|min:0|distinct',

            'y' => 'nullable|array',
            'y.*' => 'nullable|integer|min:0|distinct',

            'v' => 'nullable|array',
            'v.*' => 'nullable|array',
            'v.*.*' => 'nullable|integer|min:0|distinct',

            'price' => 'nullable|integer|min:0',

            'd' => 'nullable|string|max:255',
            
            'credit' => 'nullable|boolean',

            'swap' => 'nullable|boolean',

            'phone' => 'nullable|string|max:255',
        ]);

        $q = $request->has('q') ? $request->q : null;
        $f_users = $request->has('u') ? $request->u : [];
        $f_categories = $request->has('c') ? $request->c : [];
        $f_brands = $request->has('b') ? $request->b : [];
        $f_years = $request->has('y') ? $request->y : [];
        $f_values = $request->has('v') ? $request->v : [];
        $f_description = $request->has('d') ? $request->d : [];
        $credit = $request->has('credit') ? $request->credit : [];
        $swap = $request->has('swap') ? $request->swap : [];
        $phone = $request->phone ?: null;
        $price = $request->p ?: null;

        $products = Product::when($q, function ($query, $q) {
            return $query->where(function ($query) use ($q) {
                $query->orWhere('full_name_tm', 'like', '%' . $q . '%');
                $query->orWhere('full_name_en', 'like', '%' . $q . '%');
                $query->orWhere('slug', 'like', '%' . $q . '%');
            });
        })
        ->when($f_users, function ($query, $f_users) {
            $query->whereIn('user_id', $f_users);
        })
        ->when($f_categories, function ($query, $f_categories) {
            $query->whereIn('category_id', $f_categories);
        })
        ->when($f_brands, function ($query, $f_brands) {
            $query->whereIn('brand_id', $f_brands);
        })
        ->when($f_years, function ($query, $f_years) {
            $query->whereIn('year_id', $f_years);
        })
        ->when($f_values, function ($query, $f_values) {
            return $query->where(function ($query) use ($f_values) {
                foreach ($f_values as $f_value) {
                    $query->whereHas('values', function ($query) use ($f_value) {
                        $query->whereIn('id', $f_value);
                    });
                }
            });
        })
        ->when($f_description, function ($query, $f_description) {
            $query->whereIn('description', $f_description);
        })
        ->when($credit, function ($query) {
            $query->where('credit', 1);
        })
        ->when($swap, function ($query) {
            $query->where('swap', 1);
        })
        ->when($phone, function ($query, $phone) {
            $query->where('phone', $phone);
        })
        ->when($price, function ($query, $price) {
            $query->where('price', $price);
        })
        ->orderBy('id', 'desc')
        ->paginate(24);

        $products = $products->appends([
            'q' => $q,
            'u' => $f_users,
            'c' => $f_categories,
            'b' => $f_brands,
            'y' => $f_years,
            'v' => $f_values,
            'price' => $price,
            'f_description' => $f_description,
            'credit' => $credit,
            'swap' => $swap,
            'phone' => $phone,
        ]);

        $users = User::orderBy('name')
            ->get();
        $categories = Category::orderBy('sort_order')
            ->orderBy('slug')
            ->get();
        $brands = Brand::orderBy('slug')
            ->get();
        $attributes = Attribute::with('values')
            ->orderBy('sort_order')
            ->get();

        return view('client.product.index')
        ->with([
            'q' => $q,
            'f_users' => collect($f_users),
            'f_categories' => collect($f_categories),
            'f_brands' => collect($f_brands),
            'f_years' => collect($f_years),
            'f_values' => collect($f_values)->collapse(),
            'products' => $products,
            'users' => $users,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'price' => $price,
            'f_description' => $f_description,
            'credit' => $credit,
            'swap' => $swap,
            'phone' => $phone,
        ]);
    }


    public function create() 
    {
        $categories = Category::whereNotNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::orderBy('name')
            ->get();

        $attributes = Attribute::orderBy('sort_order')
            ->with('values')
            ->get();

        return view('client.product.create')
            ->with([
                'categories' => $categories,
                'brands' => $brands,
                'attributes' => $attributes,
            ]);
    }


    public function show($slug) 
    {
        return view('client.product.show');
    }
}
