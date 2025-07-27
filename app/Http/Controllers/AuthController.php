<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/polls');
        }
        return back()->withErrors(['email' => 'اطلاعات ورود نادرست است.']);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'با موفقیت خارج شدید.');
    }
}
