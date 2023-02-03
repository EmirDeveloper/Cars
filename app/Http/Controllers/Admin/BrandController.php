<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index() 
    {
        $objs = Brand::orderBy('name')
            ->get();

        return view('admin.brand.index')
            ->with([
                'objs' => $objs
            ]);
    }


    public function create() 
    {
        return view('admin.brand.create');
    }


    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => ['nullable', 'image', 'mimes:png', 'max:16', 'dimensions:width=200,height=200'],
        ]);

        $obj = Brand::create([
            'name' => $request->name,
        ]);

        if ($request->hasFile('image')) {
            $name = str()->random(10) . '.' . $request->image->extension();
            Storage::putFileAs('public/b', $request->image, $name);
            $obj->image = $name;
            $obj->update();
        }

        return to_route('admin.brands.index')
            ->with([
                'success' => trans('app.brand') . ' (' . $obj->getName() . ') ' . trans('app.added') . '!'
            ]);
    }


    public function edit($id) 
    {
        $obj = Brand::findOrFail($id);

        return view('admin.brand.edit');
    }


    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => ['nullable', 'image', 'mimes:png', 'max:16', 'dimensions:width=200,height=200'],
        ]);

        $obj = Brand::updateOrCreate([
            'id' => $id
        ], [
            'name' => $request->name
        ]);

        if ($request->hasFile('image')) 
        {
            if ($obj->image) 
            {
                Storage::delete('public/b', $request->image);
            } 

            $name = str()->random(10) . '.' . $request->image->extension();
            Storage::putFileAs('public/b', $request->image, $name);
            $obj->image = $name;
            $obj->update();
        }
    }

    
    public function destroy($id) 
    {
        $obj = Brand::findOrFail($id);

        $objName = $obj->name;

        if ($obj->product_count > 0) {
            return redirect()->back()
                ->with([
                    'error' => trans('app.error') . '!'
                ]);
        }

        $obj->delete();

        return redirect()->back()
            ->with([
                'success' => trans('app.brand') . ' (' . $obj->getName() . ') ' . trans('app.deleted') . '!'
            ]);
    }
}
