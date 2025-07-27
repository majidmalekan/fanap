<?php

namespace App\Http\Middleware;

use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetectUserArea
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            if ($request->is('admin') || $request->is('admin/*')) {
                session(['current_area' => UserRoleEnum::ADMIN->value]);
            } else {
                session(['current_area' => UserRoleEnum::USER->value]);
            }
        } else {
            session()->forget('current_area');
        }

        return $next($request);
    }
}
