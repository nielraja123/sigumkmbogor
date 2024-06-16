<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

// class Authenticate extends Middleware
// {
//     /**
//      * Get the path the user should be redirected to when they are not authenticated.
//      */
//     protected function redirectTo(Request $request): ?string
//     {
//         // Allow access to the home route even if not authenticated
//         if ($request->path() !== '/') {
//             return $request->expectsJson() ? null : route('login');
//         }

//         return null; // Return null to allow access to the home page without authentication
//     }
// }


class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
