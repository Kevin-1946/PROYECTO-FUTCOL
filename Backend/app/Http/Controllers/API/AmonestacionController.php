<?php

namespace App\Http\Controllers\Api;

use App\Models\amonestacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmonestacionController extends Controller
{
    public function index()
    {
        $amonestaciones = amonestacion::all();

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

        $amonestacion = amonestacion::create($request->only([
            'tarjeta_roja',
            'tarjeta_amarilla',
            'tarjeta_azul'
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
        $amonestacion = amonestacion::find($id);

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
        $amonestacion = amonestacion::find($id);

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
        $amonestacion = amonestacion::find($id);

        if (!$amonestacion) {
            return response()->json([
                'message' => 'Amonestación no encontrada',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
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
            'tarjeta_roja',
            'tarjeta_amarilla',
            'tarjeta_azul'
        ]));

        return response()->json([
            'message' => 'Amonestación actualizada',
            'amonestacion' => $amonestacion,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $amonestacion = amonestacion::find($id);

        if (!$amonestacion) {
            return response()->json([
                'message' => 'Amonestación no encontrada',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
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

        if ($request->has('tarjeta_roja')) {
            $amonestacion->tarjeta_roja = $request->tarjeta_roja;
        }
        if ($request->has('tarjeta_amarilla')) {
            $amonestacion->tarjeta_amarilla = $request->tarjeta_amarilla;
        }
        if ($request->has('tarjeta_azul')) {
            $amonestacion->tarjeta_azul = $request->tarjeta_azul;
        }

        $amonestacion->save();

        return response()->json([
            'message' => 'Amonestación actualizada parcialmente',
            'amonestacion' => $amonestacion,
            'status' => 200
        ], 200);
    }
}
