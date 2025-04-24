<?php

namespace App\Http\Controllers\API;

use App\Models\suscripcion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\Hash;


class SuscripcionController extends Controller
{
    public function index()
    {

        $suscripcion = suscripcion::all();

        if ($suscripcion->isEmpty()) {
            $data = [

                'message' => 'no se encontraron suscripciones',
                'status' => '200'
            ];
            return response()->json($data, 200);
        }

        return response()->json($suscripcion, 200);
    }



    public function store(Request $request)
    {

        $validator = validator::make($request->all(), [
            'tipo_documento' => 'required|max:20',
            'numero_documento' => 'required|unique:suscripcion|max:20',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
            'edad' => 'nullable|integer|min:15|max:60',
            'email' => 'required|email|unique:suscripcion|max:100',
            'genero' => 'required|max:10',
            'contrasena' => 'required|min:6|max:20',
            'confirmar_contrasena' => 'required|same:contrasena',
            'tipo_torneo' => 'required|max:20',
            'forma_pago' => 'required|max:20'
        ]);

        if ($validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $suscripcion = suscripcion::create([
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'edad' => $request->edad,
            'email' => $request->email,
            'genero' => $request->genero,
            'contrasena' => Hash::make($request->contrasena),
            'tipo_torneo' => $request->tipo_torneo,
            'forma_pago' => $request->forma_pago
        ]);

        if (!$suscripcion) {
            $data = [
                'message' => 'error al crear al usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'suscripcion' => $suscripcion,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $suscripcion = suscripcion::find($id);

        if (!$suscripcion) {
            $data = [
                'message' => 'suscripcion no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $suscripcion,
            'status' => 200
        ];
        return response()->json($suscripcion, 200);
    }

    public function destroy($id)
    {
        $suscripcion = suscripcion::find($id);

        if (!$suscripcion) {
            $data = [

                'message' => 'Suscripcion no encontrada',
                'status' => 404

            ];
            return response()->json($data, 404);
        }


        $suscripcion->delete();
        $data = [
            'message' => 'Suscripcion eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    
    public function update(Request $request, $id)
    {
        $suscripcion = suscripcion::find($id);
        if (!$suscripcion) {
            $data = [
                'message' => 'Suscripcion no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $validator = validator::make($request->all(), [

            'tipo_documento' => 'required|max:20',
            'numero_documento' => 'required|unique:suscripcion|max:20',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
            'edad' => 'nullable|integer|min:15|max:60',
            'email' => 'required|email|unique:suscripcion|max:100',
            'genero' => 'required|max:10',
            'contrasena' => 'required|min:6|max:20',
            'confirmar_contrasena' => 'required|same:contrasena',
            'tipo_torneo' => 'required|max:20',
            'forma_pago' => 'required|max:20'

        ]);

        if ($validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

            $suscripcion->tipo_documento = $request->tipo_documento;  // Cambiado de 'documento' a 'tipo_documento'
            $suscripcion->numero_documento = $request->numero_documento;
            $suscripcion->nombres = $request->nombres;
            $suscripcion->apellidos = $request->apellidos;
            $suscripcion->edad = $request->edad;
            $suscripcion->email = $request->email;
            $suscripcion->genero = $request->genero;
            $suscripcion->contrasena = Hash::make($request->contrasena);  // Asegúrate de hashear la contraseña
            $suscripcion->tipo_torneo = $request->tipo_torneo;
            $suscripcion->forma_pago = $request->forma_pago;
    
        

        $suscripcion->Save();

        $data = [

            'message' => 'Suscripcion actualizada',
            'suscripcion' => $suscripcion,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {

        $suscripcion = suscripcion::find($id);
        if (!$suscripcion) {
            $data = [
                'message' => 'Suscripcion no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = validator::make($request->all(), [

            'tipo_documento' => 'required|max:20',
            'numero_documento' => 'required|unique:suscripcion|max:20',
            'nombres' => 'required|max:50',
            'apellidos' => 'required|max:50',
            'edad' => 'nullable|integer|min:15|max:60',
            'email' => 'required|email|unique:suscripcion|max:100',
            'genero' => 'required|max:10',
            'contrasena' => 'required|min:6|max:20',
            'confirmar_contrasena' => 'required|same:contrasena',
            'tipo_torneo' => 'required|max:20',
            'forma_pago' => 'required|max:20'
            
            
        ]);
        if ($validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombres')) {
            $suscripcion->nombres = $request->nombres;
        }
        if ($request->has('apellidos')) {
            $suscripcion->apellidos = $request->apellidos;
        }
        if ($request->has('numero_documento')) {
            $suscripcion->numero_documento = $request->numero_documento;
        }
        if ($request->has('edad')) {
            $suscripcion->edad = $request->edad;
        }        
        if ($request->has('email')) {
            $suscripcion->email = $request->email;
        }
        
        if ($request->has('genero')) {
            $suscripcion->genero = $request->genero;
        }

        if ($request->has('contrasena')) {
            $suscripcion->contrasena = Hash::make($request->contrasena);
        }
        
        
        $suscripcion->save();

        $data = [
            'message' => 'Suscripcion actualizada',
            'suscripcion' => $suscripcion,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}

