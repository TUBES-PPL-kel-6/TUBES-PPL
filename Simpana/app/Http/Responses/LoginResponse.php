<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // Check user role and redirect accordingly
        if (Auth::user()->role === 'admin') {
            return redirect()->intended(route('admin.index'));
        }

        // Default redirect for regular users
        return redirect()->intended(route('user.dashboard'));
    }
}