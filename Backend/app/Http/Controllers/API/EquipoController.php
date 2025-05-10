<?php

namespace App\Http\Controllers\API;

use App\Models\equipo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipoController extends Controller
{
    public function index()
    {
        $equipo = equipo::all();

        if ($equipo->isEmpty()) {
            return response()->json([
                'message' => 'No se encontró equipo',
                'status' => 200
            ], 200);
        }

        return response()->json($equipo, 200);
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'nombre_de_equipo' => 'required|max:20',
            'jugadores' => ['required', 'array', 'min:6', 'max:9'],
            'jugadores.*' => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
        ]);

        if (!$Validator->fails()) {
            $jugadores = $request->jugadores;

            foreach ($jugadores as $jugador) {
                if (count(explode(' ', trim($jugador))) < 2) {
                    $Validator->errors()->add('jugadores', "El nombre '$jugador' debe contener al menos nombre y apellido.");
                }
            }

            if (count($jugadores) !== count(array_unique($jugadores))) {
                $Validator->errors()->add('jugadores', 'Hay jugadores con nombres duplicados.');
            }
        }

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $equipo = equipo::create([
            'nombre_de_equipo' => $request->nombre_de_equipo,
            'jugadores' => $request->jugadores,
        ]);

        if (!$equipo) {
            return response()->json([
                'message' => 'Error al crear el equipo',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'equipo' => $equipo,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $equipo = equipo::find($id);

        if (!$equipo) {
            return response()->json([
                'message' => 'Equipo no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json($equipo, 200);
    }

    public function destroy($id)
    {
        $equipo = equipo::find($id);

        if (!$equipo) {
            return response()->json([
                'message' => 'Equipo no encontrado',
                'status' => 404
            ], 404);
        }

        $equipo->delete();

        return response()->json([
            'message' => 'Equipo eliminado',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $equipo = equipo::find($id);

        if (!$equipo) {
            return response()->json([
                'message' => 'Equipo no encontrado',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre_de_equipo' => 'required|max:20',
            'jugadores' => ['required', 'array', 'min:6', 'max:9'],
            'jugadores.*' => ['required', 'string', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
        ]);

        if (!$Validator->fails()) {
            $jugadores = $request->jugadores;

            foreach ($jugadores as $jugador) {
                if (count(explode(' ', trim($jugador))) < 2) {
                    $Validator->errors()->add('jugadores', "El nombre '$jugador' debe contener al menos nombre y apellido.");
                }
            }

            if (count($jugadores) !== count(array_unique($jugadores))) {
                $Validator->errors()->add('jugadores', 'Hay jugadores con nombres duplicados.');
            }
        }

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $equipo->nombre_de_equipo = $request->nombre_de_equipo;
        $equipo->jugadores = $request->jugadores;
        $equipo->save();

        return response()->json([
            'message' => 'Equipo actualizado',
            'equipo' => $equipo,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $equipo = equipo::find($id);

        if (!$equipo) {
            return response()->json([
                'message' => 'Equipo no encontrado',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre_de_equipo' => 'sometimes|max:20',
            'jugadores' => 'sometimes|array|max:9',
            'jugadores.*' => 'required_with:jugadores|string|max:30',
        ]);

        if (!$Validator->fails() && $request->has('jugadores')) {
            $jugadores = $request->jugadores;

            foreach ($jugadores as $jugador) {
                if (count(explode(' ', trim($jugador))) < 2) {
                    $Validator->errors()->add('jugadores', "El nombre '$jugador' debe contener al menos nombre y apellido.");
                }
            }

            if (count($jugadores) !== count(array_unique($jugadores))) {
                $Validator->errors()->add('jugadores', 'Hay jugadores con nombres duplicados.');
            }
        }

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('nombre_de_equipo')) {
            $equipo->nombre_de_equipo = $request->nombre_de_equipo;
        }

        if ($request->has('jugadores')) {
            $equipo->jugadores = $request->jugadores;
        }

        $equipo->save();

        return response()->json([
            'message' => 'Equipo actualizado parcialmente',
            'equipo' => $equipo,
            'status' => 200
        ], 200);
    }
}