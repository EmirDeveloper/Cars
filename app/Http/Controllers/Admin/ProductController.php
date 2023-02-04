<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request) 
    {
        $request->validate([
            'q' => 'nullable|string|max:255',
            'category' => 'nullable|integer|min:1|exists:categories,id',
            'brand' => 'nullable|integer|min:1|exists:brands,id',
            'year' => 'nullable|integer|min:1|exists:years,id',
        ]);

        $q = $request->q ?: null;
        $f_category = $request->category ?: null;
        $f_brand = $request->brand ?: null;
        $f_year = $request->year ?: null;

        $objs = Product::when($q, function ($query, $q) {
            return $query->where(function ($query) use ($q) {
                $query->orWhere('code', 'like', '%' . $q . '%');
                $query->orWhere('name_tm', 'like', '%' . $q . '%');
                $query->orWhere('name_en', 'like', '%' . $q . '%');
                $query->orWhere('full_name_tm', 'like', '%' . $q . '%');
                $query->orWhere('full_name_en', 'like', '%' . $q . '%');
                $query->orWhere('slug', 'like', '%' . $q . '%');
                $query->orWhere('barcode', 'like', '%' . $q . '%');
            });
        })
            ->when($f_brand, function ($query, $f_brand) {
                $query->where('brand_id', $f_brand);
            })
            ->when($f_category, function ($query, $f_category) {
                $query->where('category_id', $f_category);
            })
            ->when($f_year, function ($query, $f_year) {
                $query->where('year_id', $f_year);
            })
            ->with(['brand', 'category.parent'])
            ->paginate(50)
            ->withQueryString();

        $categories = Category::whereNotNull('parent_id')->withCount('products')
            ->orderBy('sort_order')
            ->get();
        $brands = Brand::orderBy('name')->withCount('products')->get();

        return view('admin.product.index')
            ->with([
                'objs' => $objs,
                'brands' => $brands,
                'categories' => $categories,
                'f_brand' => $f_brand,
                'f_category' => $f_category,
                'f_year' => $f_year
            ]);
    }


    public function edit($id) 
    {
        $obj = Product::findOrFail($id);

        $categories = Category::whereNotNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::orderBy('name')
            ->get();

        $attributes = Attribute::orderBy('sort_order')
            ->with('values')
            ->get();

        $images = ProductImage::where('product_id', $id)
            ->get();

        return view('admin.product.edit')
            ->with([
                'obj' => $obj,
                'categories' => $categories,
                'brands' => $brands,
                'attributes' => $attributes,
                'images' => $images,
            ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|integer|min:1',
            'category' => 'required|integer|min:1',
            'color' => 'nullable|integer|min:1',
            'name_tm' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'phone' => 'required|string|min:0',
            'swap' => 'required|boolean|min:0',
            'credit' => 'required|boolean|min:0',
            'viewed' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'sold' => 'required|integer|min:0',
            'slug' => 'required|string|max:255',
            'favorites' => 'required|integer|min:0',
            'images' => 'nullable|array|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg|max:128|dimensions:width=1000,height=1000',
        ]);
        $brand = Brand::findOrFail($request->brand);
        $category = Category::findOrFail($request->brand);
        $gender = $request->has('gender') ? AttributeValue::findOrFail($request->gender) : null;
        $color = $request->has('color') ? AttributeValue::findOrFail($request->color) : null;
        $size = $request->has('size') ? AttributeValue::findOrFail($request->size) : null;

        $fullNameTm = $brand->name . ' '
            . $request->name_tm . ' '
            . (isset($motor) ? $motor->name_tm . ' ' : '')
            . (isset($color) ? $color->name_tm . ' ' : '')
            . $category->product_name_tm;
        $fullNameEn = $brand->name . ' '
            . ($request->name_en ?: $request->name_tm) . ' '
            . (isset($motor) ? ($motor->name_en ?: $motor->name_tm) . ' ' : '')
            . (isset($color) ? ($color->name_en ?: $color->name_tm) . ' ' : '')
            . ($category->product_name_en ?: $category->product_name_tm);

        $obj = Product::create([
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'gender_id' => $gender->id ?: null,
            'color_id' => $color->id ?: null,
            'name_tm' => $request->name_tm,
            'name_en' => $request->name_en ?: null,
            'full_name_tm' => isset($fullNameTm) ? $fullNameTm : null,
            'full_name_en' => isset($fullNameEn) ? $fullNameEn : null,
            'slug' => str()->slug($fullNameTm) . '-' . str()->random(10),
            'price' => $request->price,
            'description' => $request->description,
            'phone' => $request->phone,
            'swap' => $request->swap,
            'credit' => $request->credit,
            'viewed' => $request->viewed,
            'sold' => $request->sold,
            'favorites' => $request->favorites,
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

        return to_route('admin.products.index')
            ->with([
                'success' => @trans('app.product') . $obj->getName() . @trans('app.added') . '!'
            ]);
    }
}
