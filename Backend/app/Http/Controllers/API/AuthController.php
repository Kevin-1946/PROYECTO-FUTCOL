<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginUsuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // ✅ Excluir también el método refresh del middleware
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:10',
            'numero_documento' => 'required|string|max:20|unique:loginusuario',
            'email' => 'required|email|unique:loginusuario',
            'edad' => 'required|integer|min:0',
            'genero' => 'required|string|max:10',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuario = LoginUsuario::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'email' => $request->email,
            'edad' => $request->edad,
            'genero' => $request->genero,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['mensaje' => 'Usuario registrado exitosamente'], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['mensaje' => 'Sesión cerrada correctamente']);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    // ✅ REFRESCAR TOKEN de forma segura
    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return $this->respondWithToken($newToken);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido o expirado.'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token no proporcionado o mal formado.'], 400);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'usuario' => auth('api')->user()
        ]);
    }
}
