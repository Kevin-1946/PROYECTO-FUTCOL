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
        $jugadores = jugador::all();

        if ($jugadores->isEmpty()) {
            $data = [
                'message' => 'No se encontraron jugadores',
                'status' => '200'
            ];
            return response()->json($data, 200);
        }

        return response()->json($jugadores, 200);
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'numero_documento' => 'required|unique:jugador',
            'fecha_nacimiento' => 'required|date',
        ]);

        if ($Validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $jugador = jugador::create([
            'nombre' => $request->nombre,
            'numero_documento' => $request->numero_documento,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        if (!$jugador) {
            $data = [
                'message' => 'Error al crear el jugador',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'jugador' => $jugador,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $jugador = jugador::find($id);

        if (!$jugador) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        return response()->json($jugador, 200);
    }

    public function destroy($id)
    {
        $jugador = jugador::find($id);

        if (!$jugador) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $jugador->delete();
        $data = [
            'message' => 'Jugador eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $jugador = jugador::find($id);
        if (!$jugador) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'numero_documento' => 'required|unique:jugador,numero_documento,' . $id,
            'fecha_nacimiento' => 'required|date',
        ]);

        if ($Validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $jugador->nombre = $request->nombre;
        $jugador->numero_documento = $request->numero_documento;
        $jugador->fecha_nacimiento = $request->fecha_nacimiento;
        $jugador->save();

        $data = [
            'message' => 'Jugador actualizado',
            'jugador' => $jugador,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $jugador = jugador::find($id);
        if (!$jugador) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|max:100',
            'numero_documento' => 'sometimes|required|unique:jugador,numero_documento,' . $id,
            'fecha_nacimiento' => 'sometimes|required|date',
        ]);

        if ($Validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombre')) {
            $jugador->nombre = $request->nombre;
        }
        if ($request->has('numero_documento')) {
            $jugador->numero_documento = $request->numero_documento;
        }
        if ($request->has('fecha_nacimiento')) {
            $jugador->fecha_nacimiento = $request->fecha_nacimiento;
        }

        $jugador->save();

        $data = [
            'message' => 'Jugador actualizado',
            'jugador' => $jugador,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}