<?php

namespace App\Http\Controllers\API;

use App\Models\inscripcion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class InscripcionController extends Controller
{
    public function index()
    {

        $inscripcion = inscripcion::all();

        if ($inscripcion->isEmpty()) {
            $data = [

                'message' => 'no se encontro inscripcion',
                'status' => '200'
            ];
            return response()->json($data, 200);
        }

        return response()->json($inscripcion, 200);
    }



    public function store(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            'fecha_inscripcion' => 'required|date',
            'nombre_equipo' => 'required|max:20',
            'tipo_torneo' => 'required|max:20',
        

        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $inscripcion = inscripcion::create([
            'fecha_inscripcion' => $request->fecha_inscripcion,
            'nombre_equipo' => $request->nombre_equipo,
            'tipo_torneo' => $request->tipo_torneo,
        ]);

        if (!$inscripcion) {
            $data = [
                'message' => 'error al crear la inscripcion',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'inscripcion' => $inscripcion,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $inscripcion = inscripcion::find($id);

        if (!$inscripcion) {
            $data = [
                'message' => 'Inscripcion no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $inscripcion,
            'status' => 200
        ];
        return response()->json($inscripcion, 200);
    }

    public function destroy($id)
    {
        $inscripcion = inscripcion::find($id);

        if (!$inscripcion) {
            $data = [

                'message' => 'Inscripcion no encontrada',
                'status' => 404

            ];
            return response()->json($data, 404);
        }


        $inscripcion->delete();
        $data = [
            'message' => 'Inscripcion eliminada',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $inscripcion = inscripcion::find($id);
        if (!$inscripcion) {
            $data = [
                'message' => 'Inscripcion no encontrada',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [

            'fecha_inscripcion' => 'required|date',
            'nombre_equipo' => 'required|max:20',
            'tipo_torneo' => 'required|max:20',
            
        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $inscripcion->fecha_inscripcion = $request->fecha_inscripcion;
        $inscripcion->nombre_equipo = $request->nombre_equipo;
        $inscripcion->tipo_torneo = $request->tipo_torneo;

        $inscripcion->Save();

        $data = [

            'message' => 'Inscripcion actualizada',
            'inscripcion' => $inscripcion,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {

        $inscripcion = inscripcion::find($id);
        if (!$inscripcion) {
            $data = [
                'message' => 'Inscripcion no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'fecha_inscripcion' => 'sometimes|date',
            'nombre_equipo' => 'sometimes|max:20',
            'tipo_torneo' => 'sometimes|max:20',
            
        ]);
        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('fecha_inscripcion')) {
            $inscripcion->fecha_inscripcion = $request->fecha_inscripcion;
        }
        if ($request->has('nombre_equipo')) {
            $inscripcion->nombre_equipo = $request->nombre_equipo;
        }
        if ($request->has('tipo_torneo')) {
            $inscripcion->tipo_torneo = $request->tipo_torneo;
        }
        
        
        $inscripcion->save();

        $data = [
            'message' => 'Inscripcion actualizada',
            'inscripcion' => $inscripcion,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
