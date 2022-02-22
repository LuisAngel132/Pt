<?php
namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    protected $headers = [
        'Access-Control-Allow-Origin'      => '*',
        'Access-Control-Allow-Methods'     => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
        'Access-Control-Allow-Credentials' => true,
        'Access-Control-Max-Age'           => 60 * 60 * 24,
        'Access-Control-Allow-Headers'     => 'Origin, Content-Type, Accept, Authorization, X-Auth-Token, X-Requested-With',
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $this->headers);
        }
        $response = $next($request);
        foreach ($this->headers as $key => $value) {
            $response->header($key, $value);
        }
        return $response;
    }
}
