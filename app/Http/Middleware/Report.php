<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Report
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $route)
    {
        $str = Auth::user()->phone;
        $data = explode(",", $str);

        if ($str) {
            foreach ($data as $dataa) {
                if ($dataa == $route || $dataa == "ALL") {
                    return $next($request);
                }
            }
        }
        return redirect('/dashboard');
    }
}
