<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postulacion;
use App\Models\Llamado;
use Illuminate\Support\Facades\DB;
use Exception;

class PostulacionController extends Controller
{
  public function buscarPostulacionesDelUsuario()
  {
    try {
      $postulaciones = Postulacion::where('id_persona', auth()->user()->id)->get();

      return response()->json($postulaciones);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 406, []);
    }
  }

  public function agregarPostulacionDelUsuario(Request $request)
  {
    if ($request->id_llamado) {
      if(!Postulacion::where([['id_persona', auth()->user()->id], ['id_llamado', $request->id_llamado]])->first()) {
        $llamado = Llamado::find($request->id_llamado);
        if ($llamado) {
          $fechaDeHoy = strtotime(date('Y-m-d'));
          if ((strtotime($llamado->fecha_fin) >= $fechaDeHoy) && (strtotime($llamado->fecha_inicio) <= $fechaDeHoy)) {
            if ($llamado->vacantes > count($llamado->postulaciones)) {
              try {
                $postulacion = new Postulacion();

                $postulacion->id_persona = auth()->user()->id;
                $postulacion->id_llamado = $request->id_llamado;
                $postulacion->estado = "Postulado";
                
                $postulacion->save();
              } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 406, []);
              }
            } else {
              return response()->json(['error' => 'No hay vacantes disponibles'], 406, []);
            }
          } else {
            return response()->json(['error' => 'No se puede inscibir en esta fecha'], 406, []);
          }
        } else {
          return response()->json(['error' => 'No existe el llamado'], 406, []);
        }
      } else {
        return response()->json(['error' => 'El usuario ya se encuentra postulado al llamado'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese todos los datos requeridos'], 406, []);
    }
  }

  public function eliminarPostulacionDelUsuario($id_llamado)
  {
    if ($id_llamado) {
      $llamado = Llamado::find($id_llamado);
      if ($llamado) {
        $fechaDeHoy = strtotime(date('Y-m-d'));
        if ((strtotime($llamado->fecha_fin) >= $fechaDeHoy) && (strtotime($llamado->fecha_inicio) <= $fechaDeHoy)) {
          try {
            $postulacion = Postulacion::where([['id_persona', auth()->user()->id], ['id_llamado', $id_llamado]])->first();

            if ($postulacion) {
              $postulacion->delete();
            }
          } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 406, []);
          }
        } else {
          return response()->json(['error' => 'No se puede dar de baja en esta fecha'], 406, []);
        }
      } else {
        return response()->json(['error' => 'No existe el llamado'], 406, []);
      }
    } else {
      return response()->json(['error' => 'Ingrese el id del llamado a eliminar'], 406, []);
    }
  }
}
