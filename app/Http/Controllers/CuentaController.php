<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Cuenta;
use App\ProductVendido;
use App\Pago;

class CuentaController extends Controller
{
    public function index()
    {
        $cuentas = DB::table('cuentas')
                ->leftJoin('clients', 'clients.id', '=', 'cuentas.cliente_id')
                ->select('cuentas.*', DB::raw('clients.nombre as cliente'))
                ->get();
        $products = DB::table('product_vendidos')
                    ->select('*')
                    ->where('estado','=','Cuenta Corriente')
                    ->get();
        $lista = [];
        foreach ($cuentas as $key => $cuenta){
            foreach ($products as $product) {
                if($cuenta->id == $product->cuenta_id){
                    array_push($lista,$product);
                }
            }
            $cuenta->products = $lista;
            $lista = [];
        }
        return $cuentas;
    }

    public function store(Request $request)
    {
        $cuenta = new Cuenta();

        $cuenta->cliente_id = $request->input('cliente_id');
        $cuenta->total = $request->input('total');
        $cuenta->pagado = $request->input('pagado');
        $cuenta->deuda = $request->input('deuda');
        $cuenta->estado = $request->input('estado');
        $cuenta->batch = $request->input('batch');

        $cuenta->save();

        return $cuenta;
    }

    public function show($id)
    {
        $cuentas = DB::table('cuentas')
                ->leftJoin('clients', 'clients.id', '=', 'cuentas.cliente_id')
                ->select('cuentas.*', DB::raw('clients.nombre as cliente'))
                ->where('cuentas.cliente_id','=',$id)
                ->get();
        $products = DB::table('product_vendidos')
                    ->leftJoin('categorias', 'product_vendidos.categoria_id', '=', 'categorias.id')
                    ->select('product_vendidos.*', DB::raw('categorias.nombre as categoria'),'categorias.tipo')
                    ->where('product_vendidos.estado','=','Cuenta Corriente')
                    ->get();
        $pagos = Pago::all();

        $lista = [];
        $listaPagos = [];
        foreach ($cuentas as $key => $cuenta) {
            foreach ($products as $product) {
                if($cuenta->id == $product->cuenta_id){
                    array_push($lista,$product);
                }
            }
            foreach($pagos as $pago){
                if($cuenta->id == $pago->cuenta_id){
                    array_push($listaPagos,$pago);
                }
            }
            $cuenta->products = $lista;
            $cuenta->pagos = $listaPagos;
            $lista = [];
            $listaPagos = [];
        }
        return $cuentas;
    }

    public function update(Request $request, $id)
    {
        $cuenta = Cuenta::find($id);

        $cuenta->total = $request->input('total');
        $cuenta->pagado = $request->input('pagado');
        $cuenta->deuda = $request->input('deuda');
        $cuenta->estado = $request->input('estado');
        $cuenta->batch = $request->input('batch');

        $cuenta->save();

        return $cuenta;

    }

    public function destroy($id)
    {
        //
    }

    public function cuentasCantidad(){
        $cantidad = DB::table('cuentas')
                ->select(DB::raw('count(id) as cantidad'))
                ->where('estado','=','Deuda')
                ->get();
        return $cantidad;
    }
    public function cuentasCobrar(){
        $cobrar = DB::table('cuentas')
                ->select(DB::raw('sum(deuda) as cobrar'))
                ->where('estado','=','Deuda')
                ->get();
        return $cobrar;
    }
}
