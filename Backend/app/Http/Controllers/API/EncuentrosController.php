<?php

namespace App\Http\Controllers\API;

use App\Models\encuentros;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EncuentrosController extends Controller
{
    public function index()
    {

        $encuentros = encuentros::all();

        if ($encuentros->isEmpty()) {
            $data = [

                'message' => 'no se encontraron encuentros',
                'status' => '200'
            ];
            return response()->json($data, 200);
        }

        return response()->json($encuentros, 200);
    }



    public function store(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            'sede' => 'required|max:20',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i:s',

        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $encuentros = encuentros::create([
            'sede' => $request->sede,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            
            
        ]);

        if (!$encuentros) {
            $data = [
                'message' => 'error al crear el encuentro',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'encuentro' => $encuentros,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $encuentros = encuentros::find($id);

        if (!$encuentros) {
            $data = [
                'message' => 'Encuentro no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $encuentros,
            'status' => 200
        ];
        return response()->json($encuentros, 200);
    }

    public function destroy($id)
    {
        $encuentros = encuentros::find($id);

        if (!$encuentros) {
            $data = [

                'message' => 'Encuentro no encontrada',
                'status' => 404

            ];
            return response()->json($data, 404);
        }


        $encuentros->delete();
        $data = [
            'message' => 'Encuentro eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $encuentros = encuentros::find($id);
        if (!$encuentros) {
            $data = [
                'message' => 'encuentro no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [

            'sede' => 'required|max:20',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i:s',            

        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $encuentros->sede = $request->sede;
        $encuentros->fecha = $request->fecha;
        $encuentros->hora = $request->hora;
        
        $encuentros->Save();

        $data = [

            'message' => 'Encuentro actualizado',
            'encuentros' => $encuentros,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {

        $encuentros = encuentros::find($id);
        if (!$encuentros) {
            $data = [
                'message' => 'Encuentro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'sede' => 'sometimes|max:20',
            'fecha' => 'sometimes|date',
            'hora' => 'sometimes|date_format:H:i:s',
           
            
        ]);
        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('sede')) {
            $encuentros->sede = $request->sede;
        }
        if ($request->has('fecha')) {
            $encuentros->fecha = $request->fecha;
        }
        if ($request->has('hora')) {
            $encuentros->hora = $request->hora;
        }
        
        
        
        $encuentros->save();

        $data = [
            'message' => 'Encuentro actualizada',
            'encuentros' => $encuentros,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
