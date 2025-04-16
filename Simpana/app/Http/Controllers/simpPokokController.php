<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class simpPokokController extends Controller
{
    public function show()
    {
        return view('payment');
    }

    public function process(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Simulate payment logic
        $user->has_paid = true;
        $user->save();

        return redirect()->route('login')->with('success', 'Payment successful. You can now log in.');
    }
}
