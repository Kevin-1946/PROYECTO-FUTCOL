<?php

namespace App\Http\Controllers\Api;

use App\Models\Amonestacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmonestacionController extends Controller
{
    public function index()
    {
        $amonestaciones = Amonestacion::all();

        if ($amonestaciones->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron amonestaciones',
                'status' => 200
            ], 200);
        }

        return response()->json($amonestaciones, 200);
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'nombre_jugador' => 'required|string|max:255',
            'numero_camiseta' => 'required|integer|min:0',
            'equipo' => 'required|string|max:255',
            'encuentro_disputado' => 'required|string|max:255',
            'tarjeta_roja' => 'required|integer|min:0',
            'tarjeta_amarilla' => 'required|integer|min:0',
            'tarjeta_azul' => 'required|integer|min:0',
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $amonestacion = Amonestacion::create($request->only([
            'nombre_jugador',
            'numero_camiseta',
            'equipo',
            'encuentro_disputado',
            'tarjeta_roja',
            'tarjeta_amarilla',
            'tarjeta_azul',
        ]));

        if (!$amonestacion) {
            return response()->json([
                'message' => 'Error al crear la amonestación',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'amonestacion' => $amonestacion,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $amonestacion = Amonestacion::find($id);

        if (!$amonestacion) {
            return response()->json([
                'message' => 'Amonestación no encontrada',
                'status' => 404
            ], 404);
        }

        return response()->json($amonestacion, 200);
    }

    public function destroy($id)
    {
        $amonestacion = Amonestacion::find($id);

        if (!$amonestacion) {
            return response()->json([
                'message' => 'Amonestación no encontrada',
                'status' => 404
            ], 404);
        }

        $amonestacion->delete();

        return response()->json([
            'message' => 'Amonestación eliminada',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $amonestacion = Amonestacion::find($id);

        if (!$amonestacion) {
            return response()->json([
                'message' => 'Amonestación no encontrada',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre_jugador' => 'required|string|max:255',
            'numero_camiseta' => 'required|integer|min:0',
            'equipo' => 'required|string|max:255',
            'encuentro_disputado' => 'required|string|max:255',
            'tarjeta_roja' => 'required|integer|min:0',
            'tarjeta_amarilla' => 'required|integer|min:0',
            'tarjeta_azul' => 'required|integer|min:0',
            
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $amonestacion->update($request->only([
            'nombre_jugador',
            'numero_camiseta',
            'equipo',
            'encuentro_disputado',
            'tarjeta_roja',
            'tarjeta_amarilla',
            'tarjeta_azul',
            
        ]));

        return response()->json([
            'message' => 'Amonestación actualizada',
            'amonestacion' => $amonestacion,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $amonestacion = Amonestacion::find($id);

        if (!$amonestacion) {
            return response()->json([
                'message' => 'Amonestación no encontrada',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre_jugador' => 'sometimes|required|string|max:255',
            'numero_camiseta' => 'sometimes|required|integer|min:0',
            'equipo' => 'sometimes|required|string|max:255',
            'encuentro_disputado' => 'sometimes|required|string|max:255',
            'tarjeta_roja' => 'sometimes|required|integer|min:0',
            'tarjeta_amarilla' => 'sometimes|required|integer|min:0',
            'tarjeta_azul' => 'sometimes|required|integer|min:0',
            
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $amonestacion->fill($request->only([
            'nombre_jugador',
            'numero_camiseta',
            'equipo',
            'encuentro_disputado',
            'tarjeta_roja',
            'tarjeta_amarilla',
            'tarjeta_azul',
            
        ]));

        $amonestacion->save();

        return response()->json([
            'message' => 'Amonestación actualizada parcialmente',
            'amonestacion' => $amonestacion,
            'status' => 200
        ], 200);
    }
}