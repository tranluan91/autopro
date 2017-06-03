<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user() &&  \Auth::user()->role == User::ADMIN) {
            return $next($request);
        }

        return redirect('/');
    }
}
