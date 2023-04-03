<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProductController extends Controller
{
    public function index(Request $request) 
    {
        $request->validate([
            'q' => 'nullable|string|max:255',

            'cs' => 'nullable|array',
            'cs.*' => 'nullable|integer|min:0|distinct',

            'c' => 'nullable|array',
            'c.*' => 'nullable|integer|min:0|distinct',

            'b' => 'nullable|array',
            'b.*' => 'nullable|integer|min:0|distinct',

            'y' => 'nullable|array',
            'y.*' => 'nullable|integer|min:0|distinct',

            'ver' => 'nullable|array',
            'ver.*' => 'nullable|integer|min:0|distinct',

            'v' => 'nullable|array',
            'v.*' => 'nullable|array',
            'v.*.*' => 'nullable|integer|min:0|distinct',

            'price' => 'nullable|integer|min:0',

            'd' => 'nullable|string|max:255',
            
            'credit' => 'nullable|boolean',

            'swap' => 'nullable|boolean',

            'phone' => 'nullable|string|max:255',

            
            'color' => 'nullable|string|max:255',

            'motor' => 'nullable|string|max:255',
        ]);

        $q = $request->has('q') ? $request->q : null;
        $f_customers = $request->has('cs') ? $request->cs : [];
        $f_categories = $request->has('c') ? $request->c : [];
        $f_verifications = $request->has('ver') ? $request->ver : [];
        $f_brands = $request->has('b') ? $request->b : [];
        $f_years = $request->has('y') ? $request->y : [];
        $f_values = $request->has('v') ? $request->v : [];
        $f_description = $request->has('d') ? $request->d : [];
        $credit = $request->has('credit') ? $request->credit : [];
        $swap = $request->has('swap') ? $request->swap : [];
        $phone = $request->phone ?: null;
        $price = $request->p ?: null;
        $motor = $request->has('motor') ? AttributeValue::findOrFail($request->motor) : null;
        $color = $request->has('color') ? AttributeValue::findOrFail($request->color) : null;

        $products = Product::when($q, function ($query, $q) {
            return $query->where(function ($query) use ($q) {
                $query->orWhere('full_name_tm', 'like', '%' . $q . '%');
                $query->orWhere('full_name_en', 'like', '%' . $q . '%');
                $query->orWhere('slug', 'like', '%' . $q . '%');
            });
        })
        ->when($f_customers, function ($query, $f_customers) {
            $query->whereIn('customer_id', $f_customers);
        })
        ->when($f_categories, function ($query, $f_categories) {
            $query->whereIn('category_id', $f_categories);
        })
        ->when($f_verifications, function ($query, $f_verifications) {
            $query->whereIn('verification_id', $f_verifications);
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
        ->when($motor, function ($query, $motor) {
            $query->where('motor', $motor);
        })
        ->when($color, function ($query, $color) {
            $query->where('color', $color);
        })
        ->orderBy('id', 'desc')
        ->paginate(24);

        $products = $products->appends([
            'q' => $q,
            'cs' => $f_customers,
            'c' => $f_categories,
            'b' => $f_brands,
            'y' => $f_years,
            'v' => $f_values,
            'price' => $price,
            'f_description' => $f_description,
            'f_verifications' => $f_verifications,
            'credit' => $credit,
            'swap' => $swap,
            'phone' => $phone,
            'motor' => $motor,
            'color' => $color,
        ]);

        $customers = User::orderBy('name')
            ->get();
        $categories = Category::orderBy('sort_order')
            ->orderBy('slug')
            ->get();
        $brands = Brand::orderBy('slug')
            ->get();
        $verifications = Verification::orderBy('id')
            ->get();
        $attributes = Attribute::with('values')
            ->orderBy('sort_order')
            ->get();

        return view('client.product.index')
        ->with([
            'q' => $q,
            'f_customers' => collect($f_customers),
            'f_categories' => collect($f_categories),
            'verifications' => collect($verifications),
            'f_brands' => collect($f_brands),
            'f_years' => collect($f_years),
            'f_values' => collect($f_values)->collapse(),
            'products' => $products,
            'customers' => $customers,
            'categories' => $categories,
            'brands' => $brands,
            'attributes' => $attributes,
            'price' => $price,
            'f_description' => $f_description,
            'credit' => $credit,
            'swap' => $swap,
            'phone' => $phone,
            'motor' => $motor,
            'color' => $color,
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
        $product = Product::where('slug', $slug)
            ->with('category', 'brand')
            ->firstOrFail();

        $category = Category::findOrFail($product->category_id);
        $products = Product::where('category_id', $category->id)
            ->inRandomOrder()
            ->take(6)
            ->get([
                'id', 'category_id', 'location_id', 'name_tm', 'name_en', 'slug', 'price', 'credit', 'swap', 'description',  'created_at'
            ]);

        return view('client.product.show')
            ->with([
                'product' => $product,
                'category' => $category,
                'products' => $products,
            ]);
    }
}
