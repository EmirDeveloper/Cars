<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'integer', 'between:60000000,65999999'],
            'code' => ['required', 'integer', 'between:10000,99999'],
        ]);

        $verification = Verification::where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('updated_at', '>=', Carbon::now()->subMinutes(2))
            ->first();

        if (isset($verification)) {
            $verification->status = 1;
            $verification->update();

            // name, username, password
            $customer = Customer::where('username', $request->phone)
                ->first();

            if (isset($customer)) {
                $customer->password = bcrypt($request->code);
                $customer->update();
            } else {
                $customer = Customer::create([
                    'name' => $request->phone,
                    'username' => $request->phone,
                    'password' => bcrypt($request->code),
                ]);
            }

            auth('customer_web')->login($customer);

            return to_route('home')
                ->with([
                    'success' => 'Login Success!'
                ]);

        } else {
            return to_route('verification')
                ->with([
                    'error' => 'Verification failed!'
                ]);
        }
    }


    public function destroy(Request $request)
    {
        Auth::guard('customer_web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('home');
    }
}
