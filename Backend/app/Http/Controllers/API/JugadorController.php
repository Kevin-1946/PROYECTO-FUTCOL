<?php

namespace App\Http\Controllers\API;

use App\Models\jugador;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JugadorController extends Controller
{
    public function index()
    {
        return response()->json(jugador::all(), 200);
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'nombre_jugador' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:\s+[A-Za-zÁÉÍÓÚáéíóúÑñ]+)+$/',
                'unique:jugador,nombre_jugador',
                'max:100'
            ],
            'numero_camiseta' => 'required|integer|between:0,99',
            'edad' => 'required|integer|between:15,60',
            'nombre_equipo' => 'required|regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/|max:100',
            'goles_a_favor' => 'required|integer|between:0,99'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $jugador = jugador::create($request->all());

        if (!$jugador) {
            return response()->json([
                'message' => 'Error al crear el jugador',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'jugador' => $jugador,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $jugador = jugador::find($id);

        if (!$jugador) {
            return response()->json([
                'message' => 'Jugador no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json($jugador, 200);
    }

    public function destroy($id)
    {
        $jugador = jugador::find($id);

        if (!$jugador) {
            return response()->json([
                'message' => 'Jugador no encontrado',
                'status' => 404
            ], 404);
        }

        $jugador->delete();

        return response()->json([
            'message' => 'Jugador eliminado',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $jugador = jugador::find($id);

        if (!$jugador) {
            return response()->json([
                'message' => 'Jugador no encontrado',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre_jugador' => [
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:\s+[A-Za-zÁÉÍÓÚáéíóúÑñ]+)+$/',
                'unique:jugador,nombre_jugador,' . $id,
                'max:100'
            ],
            'numero_camiseta' => 'required|integer|between:0,99',
            'edad' => 'required|integer|between:15,60',
            'nombre_equipo' => 'required|regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/|max:100',
            'goles_a_favor' => 'required|integer|between:0,99'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $jugador->update($request->all());

        return response()->json([
            'message' => 'Jugador actualizado',
            'jugador' => $jugador,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $jugador = jugador::find($id);

        if (!$jugador) {
            return response()->json([
                'message' => 'Jugador no encontrado',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre_jugador' => [
                'sometimes',
                'required',
                'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ]+(?:\s+[A-Za-zÁÉÍÓÚáéíóúÑñ]+)+$/',
                'unique:jugador,nombre_jugador,' . $id,
                'max:100'
            ],
            'numero_camiseta' => 'sometimes|required|integer|between:0,99',
            'edad' => 'sometimes|required|integer|between:15,60',
            'nombre_equipo' => 'sometimes|required|regex:/^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s]+$/|max:100',
            'goles_a_favor' => 'sometimes|required|integer|between:0,99'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $jugador->update($request->all());

        return response()->json([
            'message' => 'Jugador actualizado',
            'jugador' => $jugador,
            'status' => 200
        ], 200);
    }
}