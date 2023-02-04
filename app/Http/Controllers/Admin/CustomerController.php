<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request) 
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'name' => ['reqiured', 'string', 'max:255'],
            'phone' => ['reqiured', 'string', 'max:255'],
        ]);

        $q = $request->q ?: null;
        $name = $request->name;
        $phone = $request->phone;
        $password = $request->password;

        $objs = Customer::when($q, function ($query, $q) {
            return $query->where(function ($query) use ($q) {
                $query->orWhere('name', 'like', '%' . $q . '%');
                $query->orWhere('phone', 'like', '%' . $q . '%');
            });
        })
        ->when(isset($name), function ($query) use ($name) {
            return $query->where('name', $name);
        })
        ->when(isset($phone), function ($query) use ($phone) {
            return $query->where('phone', $phone);
        })
        ->when(isset($password), function ($query) use ($password) {
            return $query->where('status', $password);
        })
            ->orderBy('id', 'desc')
            ->paginate(50)
            ->withQueryString();

        return view('admin.customer.index')
            ->with([
                'objs' => $objs,
            ]);
    }


    public function show() 
    {

    }


    public function edit($id) 
    {
        $objs = Customer::findOrFail($id);

        return view('admin.customer.edit')
            ->with([
                'objs' => $objs
            ]);
    }


    public function update(Request $request, $id) 
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:255'],
            'name' => ['reqiured', 'string', 'max:255'],
            'phone' => ['reqiured', 'string', 'max:255'],
            'password' => ['reqiured', 'string', 'max:255'],
        ]);

        $objs = Customer::updateOrCreate([
            'id' => $id
        ], [
            'q' => ['nullable', 'string', 'max:255'],
            'name' => ['reqiured', 'string', 'max:255'],
            'phone' => ['reqiured', 'string', 'max:255'],
            'password' => ['reqiured', 'string', 'max:255'],
        ]);

        return to_route('admin.customers.index')
            ->with([
                'success' => trans('app.customer') . ' ( ' . $objs->getName() . ' ) ' . trans('app.updated') . '!'
            ]);
    }
}
