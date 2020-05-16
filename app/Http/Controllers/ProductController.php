<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = DB::table('products')
                ->leftJoin('categorias', 'products.categoria_id', '=', 'categorias.id')
                ->select('products.*', DB::raw('categorias.nombre as categoria'))
                ->where('products.enabled',1)
                ->orderBy('products.n_serie')
                ->paginate(5);


        return $products; 
    }
    public function filtrar(Request $request){
        // Tipo 
        $tipos = [];
        $precio = [0,20000];
        $categoriasElegidas = [];
        $temporada = '';
        $hoy= '';
        $fechaElegida = '';
        $intervaloFechas = [];
        $desde = '';
        $hasta = '';
        $productos = [];
        // Tipo
        if($request->input('tipo')['Niño']) {array_push($tipos,'Niño'); };
        if($request->input('tipo')['Niña']) {array_push($tipos,'Niña'); };
        if($request->input('tipo')['Unisex']) {array_push($tipos,'Unisex'); };
        //Precio
        if($request->input('precio')['enabled']) {
            $precio = [];
            array_push($precio,$request->input('precio')['desde']);
            array_push($precio,$request->input('precio')['hasta']);
        };
        //Categoria
        if($request->input('categoria')['enabled']) {
            $listaCategorias = $request->input('categoria')['categorias'];
            foreach ($listaCategorias as $key => $categoria) {
                array_push($categoriasElegidas,$categoria['id']);
            };
        }
        //Temporada
        if($request->input('temporada')['enabled']){
            $temporada = $request->input('temporada')['temporada'];
        }
        //Fecha
        if($request->input('fecha')['enabled']){
            $fechaElegida = $request->input('fecha')['fecha'];
            $hoy = date_create();
            if($fechaElegida == 'hoy'){
                date_modify($hoy,"0 days");
            } elseif ($fechaElegida == 'ayer'){
                date_modify($hoy,"-1 days");
            } elseif ($fechaElegida == 'semana'){
                date_modify($hoy,"-7 days");
            } elseif ($fechaElegida == 'mes'){
                date_modify($hoy,"-30 days");
            } elseif ($fechaElegida == 'year'){
                date_modify($hoy,"-365 days");
            }
        }
        if($request->input('fecha')['intervaloFechas']){
            $desde = date_create($request->input('fecha')['fechaDesde']);
            $hasta = date_create($request->input('fecha')['fechaHasta']);
            date_format($desde,"Y-m-d 00:00:00");
            date_format($hasta,"Y-m-d 00:00:00");

        }
        // Producto
        if($request->input('producto')['enabled']){
            $productos = $request->input('producto')['productos'];
        }

        $products = DB::table('products')
                ->leftJoin('categorias', 'products.categoria_id', '=', 'categorias.id')
                ->select('products.*', DB::raw('categorias.nombre as categoria'),'categorias.tipo')
                ->where('products.enabled',1)

                ->whereIn('categorias.tipo',$tipos)
                ->when($request->input('precio')['enabled'], function($query) use($precio) {
                    return $query->whereBetween('products.precio',$precio);
                })
                ->when($request->input('categoria')['enabled'], function($query) use($categoriasElegidas) {
                    return $query->whereIn('categorias.id',$categoriasElegidas);
                })
                ->when($request->input('temporada')['enabled'], function($query) use($temporada) {
                    return $query->where('products.nombre',$temporada);
                })
                ->when($request->input('fecha')['enabled'], function($query) use($hoy) {
                    return $query->where('products.created_at','>',date_format($hoy,"Y-m-d 00:00:00"));
                })
                ->when($request->input('fecha')['intervaloFechas'], function($query) use($desde,$hasta) {
                    return $query->whereBetween('products.created_at',[$desde,$hasta]);
                })
                ->when($request->input('producto')['enabled'], function($query) use($productos) {
                    return $query->whereIn('products.n_serie',$productos);
                })
                ->orderBy('created_at','desc')
                ->get();
        $id = [];
        foreach ($products as $key => $product) {
            array_push($id,$product->id);
        };
    
        $stocks = DB::table('products')
                    ->leftJoin('categorias', 'products.categoria_id', '=', 'categorias.id')
                    ->select('n_serie')
                    ->whereIn('products.id',$id)
                    ->groupBy('n_serie')
                    ->paginate(5);
        $lista = [];
        foreach ($stocks as $key => $stock) {
            foreach ($products as $product) {
                if($stocks[$key]->n_serie == $product->n_serie){
                    array_push($lista,$product);
                };
            };
            $stocks[$key]->products = $lista;
        }
        return $stocks;

    }
    public function cantidadProducts(){
        $products = DB::table('products')
                ->select(DB::raw('count(id) as cantidad'))
                ->where('enabled',1)
                ->get();

        return $products;
    }

 
    public function store(Request $request)
    {
        $cantidad = $request->input('cantidadProducts');
        $productosCreados= [];

        for ($i=1; $i <= $cantidad; $i++) { 

            $product = new Product();

            $product->nombre = $request->input('nombre');
            $product->categoria_id = $request->input('categoria_id');
            $product->talle = $request->input('talle');
            $product->color = $request->input('color');
            $product->costo = $request->input('costo');
            $product->precio = $request->input('precio');
            $product->n_serie = $request->input('n_serie');
            $product->enabled = $request->input('enabled');
            $product->estado = $request->input('estado');

            $product->save();
            array_push($productosCreados, $product);

        }

        return $productosCreados;
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $product->nombre = $request->input('nombre');
        $product->categoria_id = $request->input('categoria');
        $product->stock = $request->input('stock');
        $product->precio = $request->input('precio');
        $product->n_serie = $request->input('n_serie');

        $product->save();

        return $product;
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $product->enabled = 0;
        $product->save();
        return $product;
    }
    public function stock()
    {
        $products = DB::table('products')
                ->leftJoin('categorias', 'products.categoria_id', '=', 'categorias.id')
                ->select('products.*', DB::raw('categorias.nombre as categoria'),'categorias.tipo')
                ->where('products.enabled',1)
                ->orderBy('created_at','desc')
                ->get();
        
        $stocks = DB::table('products')
                    ->select('n_serie')
                    ->where('products.enabled',1)
                    ->groupBy('n_serie')
                    ->paginate(5);
        $lista = [];
        foreach ($stocks as $key => $stock) {
            foreach ($products as $product) {
                if($stocks[$key]->n_serie == $product->n_serie){
                    array_push($lista,$product);
                };
            };
            $stocks[$key]->products = $lista;
            $lista= [];
        }

        return $stocks;
    }
    public function cantidad(){
        $products = DB::table('products')
                ->select(DB::raw('count(id) as cantidad'))
                ->where('enabled',1)
                ->get();

        return $products[0]->cantidad; 
    }
    public function precio (Request $request){
        $productosModificados= [];
        $listaProductos = $request->input();
        foreach ($listaProductos as $key => $producto) {
            $product = Product::find($producto[0]);
            $product->precio = $producto[1];
            $product->save();
            array_push($productosModificados,$product);
        }
        return $productosModificados;


    }
    public function temporadas(){
        $temporadas = DB::table('products')
                    ->select('nombre')
                    ->where('enabled',1)
                    ->whereNotNull('nombre')
                    ->groupBy('nombre')
                    ->get();
        return $temporadas;
    }
    public function buscarProducto($serie){
        $producto = DB::table('products')
                    ->select('*')
                    ->where('enabled',1)
                    ->where('n_serie','=',$serie)
                    ->paginate(5);
        return $producto;
    }
    public function todosProductos(){
        $productos = DB::table('products')
                    ->leftJoin('categorias', 'products.categoria_id', '=', 'categorias.id')
                    ->select('products.*', DB::raw('categorias.nombre as categoria'))
                    ->where('products.enabled',1)
                    ->get();
        return $productos;
    }
}
