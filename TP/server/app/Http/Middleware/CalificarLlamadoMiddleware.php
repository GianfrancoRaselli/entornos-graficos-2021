<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Llamado;

class CalificarLlamadoMiddleware
{
    public function handle($request, Closure $next)
    {
        foreach (auth()->user()->roles as $rol) {
          if ($rol->descripcion == "Administrador") return $next($request);
          if ($rol->descripcion == "Jefe Catedra") {
            $llamado = Llamado::find($request->llamado->id);
            if ($llamado && $llamado->catedra->id_jefe_catedra == auth()->user()->id) return $next($request);
          }
        }
        
        return response('No autorizado', 401);
    }
}