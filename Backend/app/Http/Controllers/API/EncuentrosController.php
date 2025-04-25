<?php

namespace App\Http\Controllers\API;

use App\Models\Encuentros;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EncuentrosController extends Controller
{
    public function index()
    {
        $encuentros = Encuentros::all();

        if ($encuentros->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron encuentros',
                'status' => 200
            ], 200);
        }

        return response()->json($encuentros, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sede' => 'required|max:50',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i:s',
            'local' => 'required|max:100',
            'visitante' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $encuentro = Encuentros::create($request->only([
            'sede', 'fecha', 'hora', 'local', 'visitante'
        ]));

        return response()->json([
            'encuentro' => $encuentro,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $encuentro = Encuentros::find($id);

        if (!$encuentro) {
            return response()->json([
                'message' => 'Encuentro no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json($encuentro, 200);
    }

    public function destroy($id)
    {
        $encuentro = Encuentros::find($id);

        if (!$encuentro) {
            return response()->json([
                'message' => 'Encuentro no encontrado',
                'status' => 404
            ], 404);
        }

        $encuentro->delete();

        return response()->json([
            'message' => 'Encuentro eliminado',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $encuentro = Encuentros::find($id);

        if (!$encuentro) {
            return response()->json([
                'message' => 'Encuentro no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'sede' => 'required|max:50',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i:s',
            'local' => 'required|max:100',
            'visitante' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $encuentro->update($request->only([
            'sede', 'fecha', 'hora', 'local', 'visitante'
        ]));

        return response()->json([
            'message' => 'Encuentro actualizado',
            'encuentro' => $encuentro,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $encuentro = Encuentros::find($id);

        if (!$encuentro) {
            return response()->json([
                'message' => 'Encuentro no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'sede' => 'sometimes|max:50',
            'fecha' => 'sometimes|date',
            'hora' => 'sometimes|date_format:H:i:s',
            'local' => 'sometimes|max:100',
            'visitante' => 'sometimes|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('sede')) $encuentro->sede = $request->sede;
        if ($request->has('fecha')) $encuentro->fecha = $request->fecha;
        if ($request->has('hora')) $encuentro->hora = $request->hora;
        if ($request->has('local')) $encuentro->local = $request->local;
        if ($request->has('visitante')) $encuentro->visitante = $request->visitante;

        $encuentro->save();

        return response()->json([
            'message' => 'Encuentro actualizado parcialmente',
            'encuentro' => $encuentro,
            'status' => 200
        ], 200);
    }
}