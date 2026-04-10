<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceCanonicalDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!app()->isProduction()) {
            return $next($request);
        }

        $canonicalDomain = config('neogtb.canonical_domain', 'neogtb.fr');
        $currentHost = $request->getHost();

        if ($currentHost !== $canonicalDomain) {
            $url = $request->getScheme() . '://' . $canonicalDomain . $request->getRequestUri();
            return redirect($url, 301);
        }

        return $next($request);
    }
}
