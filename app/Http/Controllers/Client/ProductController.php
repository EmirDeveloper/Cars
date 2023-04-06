<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Location;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Models\Verification;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

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
        ]);

        $q = $request->has('q') ? $request->q : null;
        $f_customers = $request->has('cs') ? $request->cs : [];
        $f_categories = $request->has('c') ? $request->c : [];
        $f_verifications = $request->has('ver') ? $request->ver : [];
        $f_brands = $request->has('b') ? $request->b : [];
        $f_years = $request->has('y') ? $request->y : [];
        $f_values = $request->has('v') ? $request->v : [];
        $f_description = $request->has('d') ? $request->d : null;
        $credit = $request->has('credit') ? $request->credit : null;
        $swap = $request->has('swap') ? $request->swap : null;
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
        ->orderBy('id', 'desc')
        ->with('category', 'location.parent')
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


    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|integer|min:1',
            'category' => 'required|integer|min:1',
            'location' => 'required|integer|min:1',
            'year' => 'required|integer|min:1',
            'motor' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'name_tm' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'phone' => 'nullable|string|min:0',
            'swap' => 'nullable|boolean|min:0',
            'credit' => 'nullable|boolean|min:0',
            'viewed' => 'nullable|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sold' => 'nullable|integer|min:0',
            'slug' => 'nullable|string|max:255',
            'favorites' => 'nullable|integer|min:0',
            'images' => 'nullable|array|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg|max:128|dimensions:width=1000,height=1000',
        ]);
        $brand = Brand::findOrFail($request->brand);
        $category = Category::findOrFail($request->brand);
        $location = Location::findOrFail($request->location);
        $year = Year::findOrFail($request->year);
        $motor = $request->has('motor') ? AttributeValue::findOrFail($request->motor) : null;
        $color = $request->has('color') ? AttributeValue::findOrFail($request->color) : null;

        $fullNameTm = $brand->name . ' '
            . (isset($motor) ? $motor->name_tm . ' ' : '')
            . (isset($color) ? $color->name_tm . ' ' : '')
            . $category->product_name_tm;
        $fullNameEn = $brand->name . ' '
            . (isset($motor) ? ($motor->name_en ?: $motor->name_tm) . ' ' : '')
            . (isset($color) ? ($color->name_en ?: $color->name_tm) . ' ' : '')
            . ($category->product_name_en ?: $category->product_name_tm);

        $obj = Product::create([
            'category_id' => $category->id,
            'location_id' => $location->id,
            'brand_id' => $brand->id,
            'year_id' => $year->id,
            'motor' => $motor,
            'color' => $color,
            'name_tm' => $request->name_tm,
            'name_en' => $request->name_en ?: null,
            'full_name_tm' => isset($fullNameTm) ? $fullNameTm : null,
            'full_name_en' => isset($fullNameEn) ? $fullNameEn : null,
            'slug' => str()->slug($fullNameTm) . '-' . str()->random(10),
            'price' => $request->price,
            'description' => $request->description,
            'phone' => $request->phone ?: null,
            'swap' => $request->swap ?: null,
            'credit' => $request->credit ?: null,
            'viewed' => $request->viewed ?: null,
            'sold' => $request->sold ?: null,
            'favorites' => $request->favorites ?: null,
        ]);

        if ($request->has('images')) {
            $firstImageName = "";
            $i = 0;
            foreach ($request->images as $image) {
                $name = str()->random(10) . '.' . $image->extension();
                if ($i == 0) {
                    $firstImageName = $name;
                }
                Storage::putFileAs('public/p', $image, $name);
                ProductImage::create([
                    'product_id' => $obj->id,
                    'image' => $name,
                ]);
                $i += 1;
            }
            $obj->image = $firstImageName;
            $obj->update();
        }

        return to_route('client.product.index')
            ->with([
                'success' => @trans('app.product') . $obj->getName() . @trans('app.added') . '!'
            ]);
    }


    public function create() 
    {
        $categories = Category::whereNotNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::orderBy('name')
            ->get();

        $years = Year::orderBy('name')
            ->get();

        $locations = Location::whereNotNull('parent_id')
            ->orderBy('sort_order')
            ->get();
            
        $attributes = Attribute::orderBy('sort_order')
            ->with('values')
            ->get();

        return view('client.product.create')
            ->with([
                'categories' => $categories,
                'brands' => $brands,
                'attributes' => $attributes,
                'locations' => $locations,
                'years' => $years,
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