<?php

namespace App\Http\Controllers;
use App\Pago;

use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $pago = new Pago();

        $pago->cuenta_id = $request->input('cuenta_id');
        $pago->venta_id = $request->input('venta_id');
        $pago->efectivo = $request->input('efectivo');
        $pago->tarjeta = $request->input('tarjeta');
        $pago->pagado = $request->input('pagado');
        $pago->descripcion = $request->input('descripcion');
        $pago->batch = $request->input('batch');

        $pago->save();
        return $pago;
    }

    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
