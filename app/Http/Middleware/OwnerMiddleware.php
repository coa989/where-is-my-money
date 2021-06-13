<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OwnerMiddleware
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
        $model = array_values($request->route()->parameters())[0];

        if ($model->user_id != auth()->user()->id)
        {
            abort(403);
        }

        return $next($request);
    }
}
