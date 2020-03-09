<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = DB::table('categorias')
                ->leftJoin('products', 'products.categoria_id', '=', 'categorias.id')
                ->select('categorias.*', DB::raw('count(products.id) as cantidadProductos'))
                ->where('products.enabled',1)
                ->groupBy('categorias.id')
                ->paginate(5);
        return $categorias;
    }
    public function categoriasTodas(){
        $categorias = DB::table('categorias')
                ->select('*')
                ->get();
        return $categorias;
    }
    function store(Request $request)
    {
        $categoria = new Categoria;

        $categoria->nombre = $request->input('nombre');
        $categoria->tipo = $request->input('tipo');


        $categoria->save();

        return $categoria;
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
        $categoria = Categoria::find($id);

        $categoria->delete();
    }
    public function categoriaTipo($tipo){
        $categorias = Categoria::where('tipo',strtoupper($tipo))->get();

        return $categorias;
    }
    public function cantidadCategorias(){
        $cantidad = DB::table('categorias')
                    ->leftJoin('products', 'products.categoria_id', '=', 'categorias.id')
                    ->select('categorias.*')
                    ->where('products.enabled',1)
                    ->groupBy('categorias.id')
                    ->get();
        return $cantidad; 
    }
    public function productsPorCategoria($id){
        $productos = DB::table('categorias')
                    ->leftJoin('products', 'products.categoria_id', '=', 'categorias.id')
                    ->select('products.*')
                    ->where('categorias.id','=',$id)
                    ->where('products.enabled','=',1)
                    ->get();
        return $productos;
    }
}
