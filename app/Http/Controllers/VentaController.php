<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Venta;
use App\ProductVendido;
class VentaController extends Controller
{
    public function index()
    {
        $venta = DB::table('ventas')
                ->leftJoin('clients', 'ventas.cliente_id', '=', 'clients.id')
                ->select('ventas.*', DB::raw('clients.nombre as cliente'), 'clients.telefono','clients.email')
                ->orderBy('created_at','desc')
                ->paginate(5);
        return $venta; 
    }
    public function datosVentas(Request $request){
        $desde = '';
        $hasta = '';
        $cantidadDias= 0;
        $contador = '';
        if($request->fecha['semana']['enabled']){
            $desde = date_create($request->fecha['semana']['desde']);
            $hasta = date_create($request->fecha['semana']['hasta']);
            $contador = date_format($desde,'d');
            $cantidadDias = 7;
        }
        if($request->fecha['mes']['enabled']){
            $desde = date_create($request->fecha['mes']['desde']);
            $hasta = date_create($request->fecha['mes']['hasta']);
            $contador = date_format($desde,'d');
            $cantidadDias = 31;
        }
        $ventas = DB::table('ventas')
                ->select(DB::raw('DATE(created_at) as date'),DB::raw('count(id) as cantidad'),DB::raw('sum(total) as total'))
                ->groupBy('date')
                ->where('enabled',1)
                ->where('forma_pago','!=','Cuenta' )
                ->when($request->fecha['semana']['enabled'], function($query) use($desde,$hasta) {
                    return $query->whereBetween('created_at',[$desde,$hasta]);
                })
                ->orderBy('date')
                ->get();
        $listaFechas = [];

        $arrayVacioCantidad = [];
        $arrayVacioTotal = [];

        foreach ($ventas as $key => $venta) {
            $fecha = date_create($venta->date);
            array_push($listaFechas,date_format($fecha,'d'));
            for ($contador; $contador < date_format($fecha,'d'); $contador++) { 
                array_push($arrayVacioCantidad,0);
                array_push($arrayVacioTotal,0);

            }
            $contador++;
            array_push($arrayVacioCantidad,$venta->cantidad);
            array_push($arrayVacioTotal,$venta->total);
        }
        for ($i=1; count($arrayVacioCantidad) < $cantidadDias ; $i++) { 
            array_push($arrayVacioCantidad,0);
        }
        for ($i=1; count($arrayVacioTotal) < $cantidadDias ; $i++) { 
            array_push($arrayVacioTotal,0);
        }
        $resultado = [];
       array_push($resultado,$arrayVacioCantidad);
       array_push($resultado,$arrayVacioTotal);
       array_push($resultado,$cantidadDias);



        return $resultado; 
    }
    public function ingresos($fecha)
    {
        $desde = date_create($fecha);
        $hasta = date_create($fecha);
        date_modify($hasta,"+1 days");

        date_format($desde,"Y-m-d 00:00:00");
        date_format($hasta,"Y-m-d 00:00:00");

        $venta = DB::table('ventas')
                ->select(DB::raw('sum(pagoEfectivo) as totalEfectivo'),DB::raw('sum(pagoTarjeta) as totalTarjeta'),DB::raw('count(id) as cantidad'))
                ->where('enabled',1)
                ->where('estado','!=','Seña')
                ->whereBetween('ventas.created_at',[$desde,$hasta])
                ->get();
        $sena = DB::table('ventas')
                ->select(DB::raw('sum(seña) as total'),DB::raw('count(id) as cantidad'))
                ->where('enabled',1)
                ->where('estado','=','Seña')
                ->whereBetween('ventas.created_at',[$desde,$hasta])
                ->get();
        $totalSena = $sena[0]->total;
        $cantidadSena = $sena[0]->cantidad;

        $venta[0]->totalEfectivo += $totalSena;
        $venta[0]->totalTarjeta += 0;
        $venta[0]->cantidad += $cantidadSena;
        return $venta;
    }
    public function store(Request $request)
    {
        $venta = new Venta();

        $venta->cliente_id = $request->input('cliente_id');
        $venta->forma_pago = $request->input('forma_pago');
        $venta->pagoEfectivo = $request->input('pagoEfectivo');
        $venta->pagoTarjeta = $request->input('pagoTarjeta');
        $venta->total = $request->input('total');
        $venta->seña = $request->input('seña');
        $venta->deuda = $request->input('deuda');
        $venta->promocion = $request->input('promocion');
        $venta->recargo = $request->input('recargo');
        $venta->estado = $request->input('estado');
        $venta->enabled = $request->input('enabled');

        $venta->save();

        return $venta;
    }
    public function show($id)
    {
        $venta = DB::table('ventas')
                ->leftJoin('clients', 'ventas.cliente_id', '=', 'clients.id')
                ->select('ventas.*', DB::raw('clients.nombre as cliente'), 'clients.telefono','clients.email')
                ->where('ventas.id','=',$id)
                ->get();
        $tarjetas = DB::table('tarjetas')
                    ->select('*')
                    ->where('venta_id','=',$id)
                    ->get();
        $lista = [];
        foreach ($tarjetas as $key => $tarjeta) {
            array_push($lista,$tarjeta);
        }
        $venta[0]->tarjetas = $lista;
        return $venta;
    }
    public function update(Request $request, $id)
    {
        $venta = Venta::find($id);

        $products = ProductVendido::where('venta_id',$id)->delete();

        $venta->cliente_id = $request->input('cliente_id');
        $venta->forma_pago = $request->input('forma_pago');
        $venta->pagoEfectivo = $request->input('pagoEfectivo');
        $venta->pagoTarjeta = $request->input('pagoTarjeta');
        $venta->total = $request->input('total');
        $venta->seña = $request->input('seña');
        $venta->deuda = $request->input('deuda');
        $venta->estado = $request->input('estado');

        $venta->save();

        return $venta;
    }
    public function destroy($id)
    {
        $venta = Venta::find($id);
        $venta->enabled = 0;
        $venta->estado = 'Cancelado';
        $venta->save();
        return $venta;
    }
    public function ventasSeña(){
        $venta = DB::table('ventas')
                ->leftJoin('clients', 'ventas.cliente_id', '=', 'clients.id')
                ->select('ventas.*', DB::raw('clients.nombre as cliente'), 'clients.telefono','clients.email')
                ->where('ventas.estado','=','Seña')
                ->orderBy('created_at','desc')
                ->paginate(5);
        return $venta;
    }
    public function ventasPorFecha(Request $request){
        $desde = date_create($request->input('fecha')['fecha']);
        $hasta = date_create($request->input('fecha')['fecha']);
        date_modify($hasta,"+1 days");

        date_format($desde,"Y-m-d 00:00:00");
        date_format($hasta,"Y-m-d 00:00:00");

        $ventas = DB::table('ventas')
                ->leftJoin('clients', 'ventas.cliente_id', '=', 'clients.id')
                ->select('ventas.*', DB::raw('clients.nombre as cliente'), 'clients.telefono','clients.email')
                ->when($request->input('fecha')['enabled'], function($query) use($desde,$hasta) {
                    return $query->whereBetween('ventas.created_at',[$desde,$hasta]);
                })
                ->orderBy('created_at','desc')
                ->paginate(5);
        return $ventas;

    }
}
