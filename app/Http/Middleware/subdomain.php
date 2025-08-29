<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class subdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $vald = Validator::make(['username' => $request->route('username')], [
            'username' => ['required','between:3,32','string']
        ]);

        if($vald->fails()) {
            return abort(404);
        }

        return $next($request);
    }
}
