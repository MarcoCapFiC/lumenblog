<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ShowQueryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        DB::enableQueryLog();
        /** @var Response $response */
        $response = $next($request);
        if ($response)
            $data['data'] = json_decode($response->getContent());
        $data['_queries'] = DB::getQueryLog();
        $response->setContent(json_encode($data));

        return $response;

    }

}
