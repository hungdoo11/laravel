<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminLoginMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->level == 1 || $user->level == 2) {
                return $next($request);
            } else {
                return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập khu vực admin!');
            }
        } else {
            return redirect()->route('admin.login')->with('error', 'Vui lòng đăng nhập để truy cập khu vực admin!');
        }
    }
}
