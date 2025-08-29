<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class Auth extends Authenticate
{
    /**
     * Handle an unauthenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        // var_dump($request->path);
        Cookie::queue('redirect_to',json_encode([
            'path' => '/'.$request->path(),
            'from' => 'shajara'
        ]),60,null,null,true,false);
        parent::unauthenticated($request,$guards);
    }
}
