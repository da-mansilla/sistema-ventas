<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CuentaBancaria;

class CuentaBancariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cuenta = new CuentaBancaria();

        $cuenta->titular = $request->input('titular');
        $cuenta->proveedor_id = $request->input('proveedor_id');
        $cuenta->tipo = $request->input('tipo');
        $cuenta->n_cuenta = $request->input('n_cuenta');
        $cuenta->cbu = $request->input('cbu');

        $cuenta->save();

        return $cuenta;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cuentas = CuentaBancaria::where('proveedor_id',$id)->get();

        return $cuentas;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cuenta = CuentaBancaria::find($id);

        $cuenta->titular = $request->input('titular');
        $cuenta->proveedor_id = $request->input('proveedor_id');
        $cuenta->tipo = $request->input('tipo');
        $cuenta->n_cuenta = $request->input('n_cuenta');
        $cuenta->cbu = $request->input('cbu');

        $cuenta->save();

        return $cuenta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cuenta = CuentaBancaria::find($id);

        $cuenta->delete();
        return $cuenta;
    }
}
