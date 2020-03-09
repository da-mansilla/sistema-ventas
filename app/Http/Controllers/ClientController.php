<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Client;

class ClientController extends Controller
{

    public function index()
    {
        $clients = DB::table('clients')
                    ->leftJoin('ventas', 'ventas.cliente_id', '=', 'clients.id')
                    ->select('clients.*', DB::raw('count(ventas.id) as compras'))
                    ->groupBy('clients.id')
                    ->paginate(5);



        Client::where('enabled',1)
                   ->orderBy('created_at','desc')
                   ->get();
        return $clients;
    }
    public function clientesCuentas(){
        $clients = DB::table('clients')
                    ->select('*')
                    ->where('cuenta','=',1)
                    ->paginate(5);

        $cuentas = DB::table('cuentas')
                ->select('*')
                //->where('cuentas.cliente_id','=',$id)
                ->get();
        $products = DB::table('product_vendidos')
                    ->leftJoin('categorias', 'product_vendidos.categoria_id', '=', 'categorias.id')
                    ->select('product_vendidos.*', DB::raw('categorias.nombre as categoria'),'categorias.tipo')
                    ->where('product_vendidos.estado','=','Cuenta Corriente')
                    ->get();
        $pagos = DB::table('pagos')->select('*')->get();

        $listaProductos = [];
        $listaPagos = [];
        $listaCuentas = [];
        foreach ($cuentas as $key => $cuenta) {
            foreach ($products as $product) {
                if($cuenta->id == $product->cuenta_id){
                    array_push($listaProductos,$product);
                }
            }
            foreach($pagos as $pago){
                if($cuenta->id == $pago->cuenta_id){
                    array_push($listaPagos,$pago);
                }
            }
            $cuenta->products = $listaProductos;
            $cuenta->pagos = $listaPagos;
            $listaProductos = [];
            $listaPagos = [];
        }

        foreach ($clients as $key => $client) {
            foreach ($cuentas as $key => $cuenta) {
                if($cuenta->cliente_id == $client->id){
                    array_push($listaCuentas,$cuenta);
                }
            }
            $client->cuenta = $listaCuentas;
            $listaCuentas = [];
        }
        return $clients;

    }

    public function store(Request $request)
    {
        $client = new Client;

        $client->nombre = $request->input('nombre');
        $client->telefono = $request->input('telefono');
        $client->email = $request->input('email');
        $client->enabled = $request->input('enabled');
        $client->estado = $request->input('estado');
        $client->cuenta = $request->input('cuenta');

        $client->save();

        return $client;
    }
    public function show($id)
    {
        $client = Client::find($id);

        return $client;
    }

    public function update(Request $request, $id)
    {
        $client = Client::find($id);

        $client->nombre = $request->input('nombre');
        $client->telefono = $request->input('telefono');
        $client->email = $request->input('email');

        $client->save();

        return $client;
    }

    public function destroy($id)
    {

    }
    public function disable($id)
    {
        $client = Client::find($id);

        $client->enabled = 0;
        $client->save();
        return $client->enabled;
    }
    public function crearCuenta(Request $request, $id){
        $client = Client::find($id);

        $client->cuenta = $request->input('cuenta');

        $client->save();
        return $client;
    }
    public function busqueda($nombre){
        $clientes = DB::table('clients')
                    ->select('*')
                    ->where('nombre','like','%'.$nombre.'%')
                    ->paginate(5);
        return $clientes;
    }
    public function cantidadClientes(){
        $cantidad = DB::table('clients')
                    ->select(DB::raw('count(id) as cantidad'))
                    ->get();
        return $cantidad;
    }
}
