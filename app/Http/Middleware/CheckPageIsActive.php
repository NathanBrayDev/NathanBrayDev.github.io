<?php

namespace App\Http\Middleware;

use App\Models\Page;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPageIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $page = Page::where('slug', '=', substr($request->getPathInfo(),1))->where('active', '=', 1)->first();

        if( $page || $request->getPathInfo() == "/" ) {
            return $next($request);
        } else {
            abort(404, 'Not Found');
        }
    }
}
