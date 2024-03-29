<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index() 
    {
        $objs = Category::orderBy('sort_order')
            ->with('parent')
            ->get();

        return view('admin.category.index')
            ->with([
                'objs' => $objs
            ]);
    }


    public function create() 
    {
        $parents = Category::whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.category.create')
            ->with([
                'parents' => $parents
            ]);
    }


    public function store(Request $request) 
    {
        $request->validate([
            'parent' => ['nullable', 'integer', 'min:1'],
            'name_tm' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'product_name_tm' => ['nullable', 'string', 'max:255'],
            'product_name_en' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:png', 'max:16', 'dimensions:width=200,height=200'],
        ]);

        $obj = Category::create([
            'parent_id' => $request->parent ?: null,
            'name_tm' => $request->name_tm,
            'name_en' => $request->name_en ?: null,
            'product_name_tm' => $request->product_name_tm ?: null,
            'product_name_en' => $request->product_name_en ?: null,
            'sort_order' => $request->sort_order,
        ]);

        if ($request->hasFile('image')) {
            $name = str()->random(10) . '.' . $request->image->extension();
            Storage::putFileAs('public/b', $request->image, $name);
            $obj->image = $name;
            $obj->update();
        }

        return to_route('admin.categories.index')
            ->with([
                'success' => trans('app.category') . ' (' . $obj->getName() . ') ' . trans('app.added') . '!'
            ]);
    }


    public function edit($id) 
    {
        $obj = Category::findOrFail($id);

        $parents = Category::where('id', '!=', $obj->id)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.category.edit')
            ->with([
                'obj' => $obj,
                'parents' => $parents,
            ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'parent' => ['nullable', 'integer', 'min:1'],
            'name_tm' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'product_name_tm' => ['nullable', 'string', 'max:255'],
            'product_name_en' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:png', 'max:16', 'dimensions:width=200,height=200'],
        ]);

        $obj = Category::updateOrCreate([
            'id' => $id,
        ], [
            'parent_id' => $request->parent ?: null,
            'name_tm' => $request->name_tm,
            'name_en' => $request->name_en ?: null,
            'product_name_tm' => $request->product_name_tm ?: null,
            'product_name_en' => $request->product_name_en ?: null,
            'sort_order' => $request->sort_order,
        ]);

        if ($request->hasFile('image')) {
            if ($obj->image) {
                Storage::delete('public/c/' . $obj->image);
            }
            $name = str()->random(10) . '.' . $request->image->extension();
            Storage::putFileAs('public/c', $request->image, $name);
            $obj->image = $name;
            $obj->update();
        }

        return to_route('admin.categories.index')
            ->with([
                'success' => trans('app.category') . ' (' . $obj->getName() . ') ' . trans('app.updated') . '!'
            ]);
    }


    public function destroy($id) {
        $obj = Category::findOrFail($id);

        $objName = $obj->name;

        if ($obj->child_count > 0 or $obj->product_count > 0) {
            return redirect()->back()
                ->with([
                    'error' => trans('app.error') . '!'
                ]);
        }

        $obj->delete();

        return redirect()->back()
            ->with([
                'success' => trans('app.category') . ' (' . $obj->getName() . ') ' . trans('app.deleted') . '!'
            ]);
    }
}
