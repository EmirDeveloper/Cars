<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function index() 
    {
        $obj = Year::orderBy('id', 'desc')
            ->get();

        return view('admin.year.index')
            ->with([
                'obj' => $obj
            ]);
    }
}
