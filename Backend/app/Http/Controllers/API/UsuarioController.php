<?php

namespace App\Http\Controllers\API;

use App\Models\LoginUsuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = LoginUsuario::all();

        if ($usuarios->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron usuarios',
                'status' => 200
            ], 200);
        }

        return response()->json($usuarios, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|max:20',
            'apellidos' => 'required|max:20',
            'tipo_documento' => 'required|max:20',
            'numero_documento' => 'required|unique:loginusuario',
            'email' => 'required|email|unique:loginusuario',
            'edad' => 'required|digits:2',
            'genero' => 'required|max:10',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $usuario = LoginUsuario::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'email' => $request->email,
            'edad' => $request->edad,
            'genero' => $request->genero,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'usuario' => $usuario,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $usuario = LoginUsuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json($usuario, 200);
    }

    public function destroy($id)
    {
        $usuario = LoginUsuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status' => 404
            ], 404);
        }

        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $usuario = LoginUsuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'required|max:20',
            'apellidos' => 'required|max:20',
            'tipo_documento' => 'required|max:20',
            'numero_documento' => 'required|unique:loginusuario,numero_documento,' . $id,
            'email' => 'required|email|unique:loginusuario,email,' . $id,
            'edad' => 'required|digits:2',
            'genero' => 'required|max:10',
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $usuario->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'email' => $request->email,
            'edad' => $request->edad,
            'genero' => $request->genero,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
        ]);

        return response()->json([
            'message' => 'Usuario actualizado',
            'usuario' => $usuario,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $usuario = LoginUsuario::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombres' => 'sometimes|required|max:20',
            'apellidos' => 'sometimes|required|max:20',
            'tipo_documento' => 'sometimes|required|max:20',
            'numero_documento' => 'sometimes|required|unique:loginusuario,numero_documento,' . $id,
            'email' => 'sometimes|required|email|unique:loginusuario,email,' . $id,
            'edad' => 'sometimes|required|digits:2',
            'genero' => 'sometimes|required|max:10',
            'password' => 'sometimes|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('nombres')) $usuario->nombres = $request->nombres;
        if ($request->has('apellidos')) $usuario->apellidos = $request->apellidos;
        if ($request->has('tipo_documento')) $usuario->tipo_documento = $request->tipo_documento;
        if ($request->has('numero_documento')) $usuario->numero_documento = $request->numero_documento;
        if ($request->has('email')) $usuario->email = $request->email;
        if ($request->has('edad')) $usuario->edad = $request->edad;
        if ($request->has('genero')) $usuario->genero = $request->genero;
        if ($request->has('password')) $usuario->password = bcrypt($request->password);

        $usuario->save();

        return response()->json([
            'message' => 'Usuario actualizado parcialmente',
            'usuario' => $usuario,
            'status' => 200
        ], 200);
    }
}