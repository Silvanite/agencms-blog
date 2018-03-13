<?php

namespace Agencms\Blog\Middleware;

use Closure;
use Agencms\Blog\Handlers\AgencmsHandler;

class AgencmsConfig
{
    /**
     * Register Agencms endpoints
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        AgencmsHandler::registerAdmin();
        return $next($request);
    }
}
