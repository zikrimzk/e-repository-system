<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if(!Auth::guard('staff')->check())
        {
            return $request->expectsJson() ? null : route('staff.login');
        }
        if(!Auth::guard('web')->check())
        {
            return $request->expectsJson() ? null : route('student.login');
        }
    }
}
