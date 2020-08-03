<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ProductVendido;
use App\Venta;
use App\Product;

class ProductVendidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $productsVendidos = DB::table('product_vendidos')
                            ->leftJoin('categorias', 'product_vendidos.categoria_id', '=', 'categorias.id')
                            ->select('product_vendidos.*', DB::raw('categorias.nombre as categoria'),'categorias.tipo')
                            ->where('product_vendidos.venta_id','=',$id)
                            ->get();

        return $productsVendidos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request,$venta_id)
    {
        $productVendido = new ProductVendido();

        $productVendido->venta_id = $venta_id;
        $productVendido->nombre = $request->input('nombre');
        $productVendido->categoria_id= $request->input('categoria_id');
        $productVendido->cuenta_id= $request->input('cuenta_id');
        $productVendido->n_serie=  $request->input('n_serie');
        $productVendido->talle=  $request->input('talle');
        $productVendido->color=  $request->input('color');
        $productVendido->costo = $request->input('costo');
        $productVendido->precio = $request->input('precio');
        $productVendido->cantidad = $request->input('cantidad');
        $productVendido->descuento = $request->input('descuento');
        $productVendido->estado = $request->input('estado');

        if($request->input('enableFecha')){
            $nuevaFecha = date_create($request->input('fecha'));
            $productVendido->created_at = $nuevaFecha;
        }

        $productVendido->save();

        return $productVendido;
    }

    public function productsVendidosPorCategoria(Request $request){
        $categoriasList = $request->input();
        $productos = [];

            $products = DB::table('product_vendidos')
                        ->leftJoin('categorias','product_vendidos.categoria_id','=','categorias.id')
                        ->select('categorias.id', DB::raw('categorias.nombre as nombre_categoria'),'categorias.tipo','product_vendidos.*')
                        ->whereIn('product_vendidos.categoria_id', $categoriasList)
                        ->get();

        return $products; 
        
    }

    public function show($id)
    {
        //
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
        $productVendido = ProductVendido::find($id);

        $productVendido->estado = $request->input('estado');

        $productVendido->save();
        return $productVendido;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function finalizarProducto($id){
        $product = ProductVendido::find($id);

        $product->estado = 'Vendido';

        $product->save();
        return $product;
    }
}
