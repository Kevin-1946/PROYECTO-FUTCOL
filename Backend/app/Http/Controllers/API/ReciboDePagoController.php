<?php

namespace App\Http\Controllers\API;

use App\Models\recibo_de_pago;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReciboDePagoController extends Controller
{
    public function index()
    {
        $recibos = recibo_de_pago::all();

        if ($recibos->isEmpty()) {
            $data = [
                'message' => 'No se encontraron recibos de pago',
                'status' => 200
            ];
            return response()->json($data, 200);
        }

        return response()->json($recibos, 200);
    }

    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'confirmacion_de_pago' => 'required|boolean',
            'fecha_emision' => 'required|date',
            'monto' => 'required|numeric|min:0',
        ]);

        if ($Validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $recibo = recibo_de_pago::create($request->only([
            'confirmacion_de_pago',
            'fecha_emision',
            'monto'
        ]));

        if (!$recibo) {
            return response()->json([
                'message' => 'Error al crear el recibo de pago',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'recibo' => $recibo,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $recibo = recibo_de_pago::find($id);

        if (!$recibo) {
            return response()->json([
                'message' => 'Recibo de pago no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json($recibo, 200);
    }

    public function destroy($id)
    {
        $recibo = recibo_de_pago::find($id);

        if (!$recibo) {
            return response()->json([
                'message' => 'Recibo de pago no encontrado',
                'status' => 404
            ], 404);
        }

        $recibo->delete();

        return response()->json([
            'message' => 'Recibo de pago eliminado',
            'status' => 200
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $recibo = recibo_de_pago::find($id);

        if (!$recibo) {
            return response()->json([
                'message' => 'Recibo de pago no encontrado',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'confirmacion_de_pago' => 'required|boolean',
            'fecha_emision' => 'required|date',
            'monto' => 'required|numeric|min:0',
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        $recibo->update($request->only([
            'confirmacion_de_pago',
            'fecha_emision',
            'monto'
        ]));

        return response()->json([
            'message' => 'Recibo de pago actualizado',
            'recibo' => $recibo,
            'status' => 200
        ], 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $recibo = recibo_de_pago::find($id);

        if (!$recibo) {
            return response()->json([
                'message' => 'Recibo de pago no encontrado',
                'status' => 404
            ], 404);
        }

        $Validator = Validator::make($request->all(), [
            'confirmacion_de_pago' => 'sometimes|required|boolean',
            'fecha_emision' => 'sometimes|required|date',
            'monto' => 'sometimes|required|numeric|min:0',
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $Validator->errors(),
                'status' => 400
            ], 400);
        }

        if ($request->has('confirmacion_de_pago')) {
            $recibo->confirmacion_de_pago = $request->confirmacion_de_pago;
        }
        if ($request->has('fecha_emision')) {
            $recibo->fecha_emision = $request->fecha_emision;
        }
        if ($request->has('monto')) {
            $recibo->monto = $request->monto;
        }

        $recibo->save();

        return response()->json([
            'message' => 'Recibo de pago actualizado parcialmente',
            'recibo' => $recibo,
            'status' => 200
        ], 200);
    }
}
