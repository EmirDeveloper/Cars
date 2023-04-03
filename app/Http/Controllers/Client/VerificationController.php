<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function create()
    {
        return view('client.auth.verification');
    }


    public function store(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'integer', 'between:60000000,65999999'],
        ]);

        $code = rand(10000, 99999);
        $verification = Verification::updateOrCreate([
            'phone' => $request->phone
        ], [
            'code' => $code,
            'status' => 0,
        ]);

        // send sms

        return view('client.auth.login')
            ->with([
                'phone' => $verification->phone,
                'success' => 'Verification code sent!',
                'code' => $code,
            ]);
    }
}