<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaginationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $perPage = $request->query("per_page");
        $maxPerPage = 15;
        if ($perPage > $maxPerPage) {
            $request->merge(["per_page" => $maxPerPage]);
        }
        return $next($request);
    }
}
