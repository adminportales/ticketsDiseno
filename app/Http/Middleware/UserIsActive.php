<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->status !== 1) {
            return redirect('home/inactive');
        }
        return $next($request);
    }
}
