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
            $data = [

                'message' => 'no se encontro equipo',
                'status' => '200'
            ];
            return response()->json($data, 200);
        }

        return response()->json($equipo, 200);
    }



    public function store(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            'nombre_de_equipo' => 'required|max:20',

        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $equipo = equipo::create([
           'nombre_de_equipo' => 'required|max:20',
        ]);

        if (!$equipo) {
            $data = [
                'message' => 'error al crear el equipo',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'equipo' => $equipo,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $equipo = equipo::find($id);

        if (!$equipo) {
            $data = [
                'message' => 'Equipo no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $equipo,
            'status' => 200
        ];
        return response()->json($equipo, 200);
    }

    public function destroy($id)
    {
        $equipo = equipo::find($id);

        if (!$equipo) {
            $data = [

                'message' => 'Equipo no encontrado',
                'status' => 404

            ];
            return response()->json($data, 404);
        }


        $equipo->delete();
        $data = [
            'message' => 'Equipo eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $equipo = equipo::find($id);
        if (!$equipo) {
            $data = [
                'message' => 'Equipo no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [

           'nombre_de_equipo' => 'required|max:20',
        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $equipo->nombre_de_equipo = $request->nombre_de_equipo;
        

        $equipo->Save();

        $data = [

            'message' => 'equipo actualizado',
            'inscripcion' => $equipo,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {

        $equipo = equipo::find($id);
        if (!$equipo) {
            $data = [
                'message' => 'Equipo no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'nombre_de_equipo' => 'sometimes|max:20',

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
            $equipo->nombre_de_equipo = $request->nombre_de_equipo;
        }
       


        $equipo->save();

        $data = [
            'message' => 'Equipo actualizado',
            'inscripcion' => $equipo,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
