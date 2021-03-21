<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectByUserLang
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
        if (Auth::check()) {
            $url_array = explode('.', parse_url($request->url(), PHP_URL_HOST));

            if (count($url_array) < 4) {
                if (Auth::user()->site_language == 'hu') {
                    return $next($request);
                } else {
                    return redirect(str_replace('://', '://'.Auth::user()->site_language.'.', $request->url()));
                }
            }

            $subdomain = $url_array[0];
            $languages = ['en','de'];

            if (!in_array($subdomain, $languages)) return redirect(str_replace($subdomain.'.', '', $request->url()));

            if (Auth::user()->site_language != $subdomain) {
                if (Auth::user()->site_language != 'hu') {
                    return redirect(str_replace('://', '://'.Auth::user()->site_language.'.', $request->url()));
                } else {
                    return redirect(str_replace($subdomain.'.', '', $request->url()));
                }
            }
        }

        return $next($request);
    }
}