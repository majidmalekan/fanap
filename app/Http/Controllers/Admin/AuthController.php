<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $credentials["role"] = UserRoleEnum::ADMIN->value;
        if ($this->userService->authAttempt($credentials)) {
            return redirect()->intended('/admin/polls');
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

        return redirect()->route('admin.login')->with('success', 'با موفقیت خارج شدید.');
    }
}
