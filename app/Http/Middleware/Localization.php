<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    
    /**
     * Middleware for handling localization of incoming requests.
     *
     * This middleware is responsible for handling the localization of incoming requests.
     * It sets the locale of the application based on the user's preferred language.
     *
     * @param  \Illuminate\Http\Request $request The incoming request.
     * @param  \Closure                 $next    The next middleware.
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
    
        return $next($request);
    }
}