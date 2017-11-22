<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\AclPermiso;

class Acl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {        
    	$permisos = AclPermiso::join('acl_permisos_grupos AS pg', 'acl_permisos.id', '=', 'pg.permiso_id')
    						->join('acl_grupos_usuarios AS gu', 'pg.grupo_id', '=', 'gu.grupo_id')
    						->where('gu.user_id', Auth::user()->id)
    						->get();
    						#dd($permisos);

    	if ($permisos->isEmpty())
    	{
    		if ($request->ajax())
            {
                return response()->json(['success' => false, 'permisos' => 'No tenes suficientes permisos'], 401);
            }
            else
            {
                dd('no tenes permisos');
            }
    	}

        $uri = $request->path();

        foreach ($permisos AS $permiso)
        {
            #dd(Auth::user(), $guard, $user, $uri, $permiso);
            if (!Auth::user()->can($permiso->nombre) && $permiso->url == $uri)
            {
                if ($request->ajax())
                {
                    return response()->json(['success' => false, 'permisos' => 'No tenes suficientes permisos'], 401);
                }
                else
                {
                    #abort(403);
                }
            }
        }

        return $next($request);
    }
}
