<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
          case 'admin':
            if (Auth::guard($guard)->check()) {
              return redirect('admin');
            }
            break;

          case 'teacher':
            if (Auth::guard($guard)->check()) {
              return redirect('teacher');
            }
            break;

          case 'student':
            if (Auth::guard($guard)->check()) {
              return redirect('student');
            }
            break;

          default:
            // default is for user
            if (Auth::guard($guard)->check()) {
              return redirect('/');
            }
            break;
        }
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/');
        // }

        return $next($request);
    }
}
