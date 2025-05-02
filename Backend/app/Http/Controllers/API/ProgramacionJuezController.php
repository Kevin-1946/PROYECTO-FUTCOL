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

        if ($jueces->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron jueces',
                'status' => 200
            ], 200);
        }

        return response()->json($jueces, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'numero_de_contacto' => 'required|max:15',
            'sede' => 'required|max:100',
            'encuentros_id' => 'required|exists:encuentros,id'
        ]);

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

        return response()->json($juez, 200);
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

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'numero_de_contacto' => 'required|max:15',
            'sede' => 'required|max:100',
            'encuentros_id' => 'required|exists:encuentros,id'
        ]);

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
        ], 200);
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

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|max:50',
            'numero_de_contacto' => 'sometimes|required|max:15',
            'sede' => 'sometimes|required|max:100',
            'encuentros_id' => 'sometimes|required|exists:encuentros,id'
        ]);

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
        ], 200);
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
        ], 200);
    }
}