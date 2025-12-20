<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Utilities\Constant;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('admin_id')) {
            return redirect('admin')->with('notification', 'ERROR');
        }

        return $next($request);
    }
}