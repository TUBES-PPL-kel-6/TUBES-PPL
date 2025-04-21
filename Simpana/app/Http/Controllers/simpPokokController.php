<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class simpPokokController extends Controller
{
    public function show()
    {
        // Get the authenticated user and pass it to the view
        $user = Auth::user();
        return view('payment', compact('user'));
    }

    public function process(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Update the user's payment status
        $user->update([
            'has_paid' => true,
        ]);

        return redirect()->route('login')->with('success', 'Payment successful. You can now log in.');
    }
}
