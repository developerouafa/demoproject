<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;

class checkAdminToken
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        }catch(\Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('E3001', 'Invalid Token');
            }elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001', 'Expired Token');
            }else{
                return $this->returnError('E3001', 'Token not found');
            }
        }catch(\Throwable $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->returnError('E3001', 'Invalid Token');
            }elseif($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->returnError('E3001', 'Expired Token');
            }else{
                return $this->returnError('E3001', 'Token not found');
            }
        }

        if(!$user){
            $this->returnError('E3001', 'Unauthenticated');
        }
        return $next($request);
    }
}
