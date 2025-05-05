<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LoginUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'forgotPassword', 'resetPassword']]);
    }

    // ✅ Método de registro existente
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

    // ✅ Método de login mejorado
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciales inválidas'], 401);
            }

            return $this->respondWithToken($token);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo crear el token'], 500);
        }
    }

    // ✅ Método de logout
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['mensaje' => 'Sesión cerrada correctamente']);
    }

    // ✅ Método para obtener usuario autenticado
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    // ✅ Método para refrescar token
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

    // ✅ Método para recuperación de contraseña
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = LoginUsuario::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Si el email existe, te enviaremos un enlace de recuperación'], 200);
        }

        // Generar token
        $token = Str::random(60);
        $expiresAt = Carbon::now()->addHours(1);

        // Guardar token en la base de datos
        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // Enviar email
        $resetLink = url(config('app.url') . '/reset-password?token=' . $token . '&email=' . urlencode($user->email));
        
        Mail::to($user->email)->send(new PasswordResetMail($resetLink));

        return response()->json(['message' => 'Si el email existe, te enviaremos un enlace de recuperación']);
    }

    // ✅ Método para restablecer contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $resetRecord = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return response()->json(['error' => 'Token inválido o expirado'], 400);
        }

        // Actualizar contraseña
        $user = LoginUsuario::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
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
