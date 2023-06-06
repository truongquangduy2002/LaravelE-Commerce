<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        $notification = array(
            'message' => 'Login Successfully',
            'alert-type' => 'success'
        );

        $url = '';
        $user = $request->user();

        if ($user->role === 'admin') {
            // Nếu người dùng là admin, chuyển hướng đến màn hình admin
            $url = '/admin/dashboard';
        } else if ($user->role === 'vendor') {
            // Nếu người dùng là vendor, chuyển hướng đến màn hình vendor
            $url = '/vendor/dashboard';
        } else if ($user->role === 'user') {
            // Nếu người dùng là user, chuyển hướng đến màn hình user
            $url = '/dashboard';
        }

        return redirect()->intended($url)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
