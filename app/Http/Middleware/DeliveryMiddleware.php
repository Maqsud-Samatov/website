<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeliveryMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'delivery') {
            return $next($request);
        }
        return redirect('/dashboard')->with('error', 'Ruxsat yo\'q!');
    }
}