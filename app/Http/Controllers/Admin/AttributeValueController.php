<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    public function create() 
    {
        $attributes = Attribute::orderBy('sort_order')->get();

        return view('admin.attribute.value.create')
            ->with([
                'attributes' => $attributes,
            ]);;
    }


    public function store(Request $request) 
    {
        $request->validate([
            'attribute' => ['required', 'integer', 'min:1'],
            'name_tm' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:1'],
        ]);

        $obj = AttributeValue::create([
            'attribute_id' => $request->attribute,
            'name_tm' => $request->name_tm,
            'name_en' => $request->name_en ?: null,
            'sort_order' => $request->sort_order,
        ]);
        return to_route('admin.attributes.index')
            ->with([
                'success' => trans('app.attributeValue') . ' (' . $obj->getName() . ') ' . trans('app.added') . '!'
            ]);
    }


    public function edit($id)
    {
        $obj = AttributeValue::findOrFail($id);
        $attributes = Attribute::orderBy('sort_order')
            ->get();
        
        return view('admin.attribute.value.edit')
            ->with([
                'obj' => $obj,
                'attributes' => $attributes,
            ]);
    }


    public function update(Request $request, $id) 
    {
        $request->validate([
            'attribute' => ['required|integer|min:1'],
            'name_tm' => ['required|string|max:255'],
            'name_en' => ['nullable|string|max:255'],
            'sort_order' => ['required|string|min:1'],
        ]);

        $obj = AttributeValue::updateOrCreate([
            'id' => $id
        ], [
            'attribute' => $request->attribute,
            'name_tm' => $request->name_tm,
            'name_en' => $request->name_en ?: null,
            'sort_order' => $request->sort_order,
        ]);

        return to_route('admin.attributes.index')
            ->with([
                'success' => trans('app.attributeValue') . ' ( ' . $obj->getName() . ' ) ' . trans('app.updated') . '!'
            ]);
    }


    public function destroy($id) 
    {
        $obj = AttributeValue::withCount('products')
            ->findOrFail($id);

        $objName = $obj->name;

        if ($obj->products_count > 0) 
        {
            return redirect()->back()
                ->with([
                    'error' => trans('error') . '!'
                ]);
        }

        $obj->delete();

        return redirect()->back()
            ->with([
                'success' => trans('app.attribute') . ' ( ' . $obj->getName() . ' ) ' . trans('app.deleted') . '!'
            ]);
    }
}
