<?php

namespace App\Http\Controllers\Api;

use App\Models\ProgramacionJuez;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramacionJuezController extends Controller
{
    public function index()
    {
        $jueces = ProgramacionJuez::with('encuentro')->get();

        // Siempre retornar un array, aunque esté vacío
        return response()->json($jueces);
    }

    private function validateData($data, $partial = false)
    {
        $rules = [
            'nombre' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ]+(?:\s[A-Za-zÁÉÍÓÚáéíóúñÑ]+)+$/', 'max:50'],
            'numero_de_contacto' => ['required', 'regex:/^\d{7,10}$/'],
            'sede' => ['required', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ0-9\s]+$/', 'max:100'],
            'encuentros_id' => ['required', 'exists:encuentros,id'],
        ];

        if ($partial) {
            foreach ($rules as $field => $ruleSet) {
                $rules[$field] = array_merge(['sometimes'], $ruleSet);
            }
        }

        return Validator::make($data, $rules);
    }

    public function store(Request $request)
    {
        $validator = $this->validateData($request->all());

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $juez = ProgramacionJuez::create($request->all());

        return response()->json([
            'juez' => $juez,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $juez = ProgramacionJuez::with('encuentro')->find($id);

        if (!$juez) {
            return response()->json([
                'message' => 'Juez no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json($juez);
    }

    public function update(Request $request, $id)
    {
        $juez = ProgramacionJuez::find($id);

        if (!$juez) {
            return response()->json([
                'message' => 'Juez no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = $this->validateData($request->all());

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $juez->update($request->all());

        return response()->json([
            'message' => 'Juez actualizado',
            'juez' => $juez,
            'status' => 200
        ]);
    }

    public function updatePartial(Request $request, $id)
    {
        $juez = ProgramacionJuez::find($id);

        if (!$juez) {
            return response()->json([
                'message' => 'Juez no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = $this->validateData($request->all(), true);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $juez->update($request->all());

        return response()->json([
            'message' => 'Juez actualizado parcialmente',
            'juez' => $juez,
            'status' => 200
        ]);
    }

    public function destroy($id)
    {
        $juez = ProgramacionJuez::find($id);

        if (!$juez) {
            return response()->json([
                'message' => 'Juez no encontrado',
                'status' => 404
            ], 404);
        }

        $juez->delete();

        return response()->json([
            'message' => 'Juez eliminado',
            'status' => 200
        ]);
    }
}