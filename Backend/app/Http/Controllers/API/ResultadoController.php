<?php

namespace App\Http\Controllers\API;

use App\Models\resultados;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ResultadoController extends Controller
{
    public function index()
    {

        $resultados = resultados::all();

        if ($resultados->isEmpty()) {
            $data = [

                'message' => 'no se encontraron resulatados',
                'status' => '200'
            ];
            return response()->json($data, 200);
        }

        return response()->json($resultados, 200);
    }



    public function store(Request $request)
    {

        $Validator = Validator::make($request->all(), [
            'puntos' => 'required|digits:2',
            'partidos_jugados' => 'required|digits:2',
            'goles_a_favor' => 'required|digits:2',
            'goles_en_contra' => 'required|digits:2',
            'diferencia_de_goles' => 'required|digits:2',
            'equipo' => 'required|max:20',

        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $resultados = resultados::create([
            'puntos' => $request->puntos,
            'partidos_jugados' => $request->partidos_jugados,
            'goles_a_favor' => $request->goles_a_favor,
            'goles_en_contra' => $request->goles_en_contra,
            'diferencia_de_goles' => $request->diferencia_de_goles,   
            'equipo' => $request->equipo        
          
        ]);

        if (!$resultados) {
            $data = [
                'message' => 'error al crear el resultado',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'resultados' => $resultados,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id)
    {
        $resultados = resultados::find($id);

        if (!$resultados) {
            $data = [
                'message' => 'resultado no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $data = [
            'message' => $resultados,
            'status' => 200
        ];
        return response()->json($resultados, 200);
    }

    public function destroy($id)
    {
        $resultados = resultados::find($id);

        if (!$resultados) {
            $data = [

                'message' => 'Resultado no encontrado',
                'status' => 404

            ];
            return response()->json($data, 404);
        }


        $resultados->delete();
        $data = [
            'message' => 'Resultado eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    public function update(Request $request, $id)
    {
        $resultados = resultados::find($id);
        if (!$resultados) {  
            $data = [
                'message' => 'Resultado no encontrado',
                'status' => 400
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [

            'puntos' => 'required|digits:2',
            'partidos_jugados' => 'required|digits:2',
            'goles_a_favor' => 'required|digits:2',
            'goles_en_contra' => 'required|digits:2',
            'diferencia_de_goles' => 'required|digits:2',
            'equipo' => 'required|max:20',

        ]);

        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $resultados->puntos = $request->nombres ;
        $resultados->partidos_jugados = $request->apellidos;
        $resultados->goles_a_favor = $request->documento;
        $resultados->goles_en_contra = $request->edad;
        $resultados->diferencia_de_goles = $request->email;
        $resultados->equipo = $request->genero;
    
        

        $resultados->Save();

        $data = [

            'message' => 'Resultado actualizada',
            'resultados' => $resultados,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {

        $resultados = resultados::find($id);
        if (!$resultados) {
            $data = [
                'message' => 'Resultado no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $Validator = Validator::make($request->all(), [
            'puntos' => 'sometimes|digits:2',
            'partidos_jugados' => 'sometimes|digits:2',
            'goles_a_favor' => 'sometimes|digits:2',
            'goles_en_contra' => 'sometimes|digits:2',
            'diferencia_de_goles' => 'sometimes|digits:2',
            'equipo' => 'sometimes|max:20',
            
            
        ]);
        if ($Validator->Fails()) {

            $data = [
                'message' => 'error en la validacion de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('puntos')) {
            $resultados->puntos = $request->puntos;
        }
        if ($request->has('partidos_jugados')) {
            $resultados->partidos_jugados = $request->partidos_jugados;
        }
        if ($request->has('goles_a_favor')) {
            $resultados->goles_a_favor = $request->goles_a_favor;
        }
        if ($request->has('goles_en_contra')) {
            $resultados->goles_en_contra = $request->goles_en_contra;
        }        
        if ($request->has('diferencia_de_goles')) {
            $resultados->diferencia_de_goles = $request->diferencia_de_goles;
        }
        
        if ($request->has('equipo')) {
            $resultados->equipo = $request->equipo;
        }
        
        
        $resultados->save();

        $data = [
            'message' => 'Resultado actualizada',
            'resultados' => $resultados,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}

