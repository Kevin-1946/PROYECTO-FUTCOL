<?php

namespace App\Http\Controllers\API;

use App\Models\juez;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JuezController extends Controller
{
    public function index()
    {
        $jueces = juez::all();

        if ($jueces->isEmpty()) {
            $data = [
                'message' => 'No se encontraron jueces',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        return response()->json($jueces, 200);
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'numero_de_contacto' => 'required|max:15'
        ]);

        if ($Validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $juez = juez::create([
            'nombre' => $request->nombre,
            'numero_de_contacto' => $request->numero_de_contacto
        ]);

        if (!$juez) {
            $data = [
                'message' => 'Error al crear el juez',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'juez' => $juez,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $juez = juez::find($id);

        if (!$juez) {
            $data = [
                'message' => 'Juez no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        return response()->json($juez, 200);
    }

    public function destroy($id)
    {
        $juez = juez::find($id);

        if (!$juez) {
            $data = [
                'message' => 'Juez no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $juez->delete();

        $data = [
            'message' => 'Juez eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $juez = juez::find($id);

        if (!$juez) {
            $data = [
                'message' => 'Juez no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'numero_de_contacto' => 'required|max:15'
        ]);

        if ($Validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $juez->nombre = $request->nombre;
        $juez->numero_de_contacto = $request->numero_de_contacto;

        $juez->save();

        $data = [
            'message' => 'Juez actualizado',
            'juez' => $juez,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $juez = juez::find($id);

        if (!$juez) {
            $data = [
                'message' => 'Juez no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|max:50',
            'numero_de_contacto' => 'sometimes|required|max:15'
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
            $juez->nombre = $request->nombre;
        }

        if ($request->has('numero_de_contacto')) {
            $juez->numero_de_contacto = $request->numero_de_contacto;
        }

        $juez->save();

        $data = [
            'message' => 'Juez actualizado parcialmente',
            'juez' => $juez,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
