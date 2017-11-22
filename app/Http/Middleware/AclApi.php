<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Auth;
use App\AclPermiso;

class AclApi extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        if (!$user) {
            return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
        }

        $uri = $request->path();

        /*$permisos = AclPermiso::join('acl_permisos_grupos AS pg', 'acl_permisos.id', '=', 'pg.permiso_id')
                            ->join('acl_grupos_usuarios AS gu', 'pg.grupo_id', '=', 'gu.grupo_id')
                            ->where('gu.user_id', $user->id)
                            ->get();*/

        $permisos = AclPermiso::all();

        #if ($permisos->isEmpty())
            #return $this->respond('tymon.jwt.invalid', 'sin_permiso1s', 401, 'Unauthorized');

        foreach ($permisos AS $permiso)
        {
            dd($user->can($permiso->nombre));
            #dd($permiso, $user);
            #dd(Auth::user(), $guard, $user, $uri, $permiso);
            if (!$user->can($permiso->nombre) && $permiso->url == $uri)
            {
                return $this->respond('tymon.jwt.invalid', 'sin_permisos', 401, 'Unauthorized');
            }
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}