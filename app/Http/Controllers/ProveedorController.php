<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedor;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedores = Proveedor::all();
        return $proveedores;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function messages(){
    	return [
        'empresa.required' => 'Este Campo es Requerido',
		'razon_social.required' => 'Este Campo es Requerido',
		'direccion.required' => 'Este Campo es Requerido',
		'ciudad.required' => 'Este Campo es Requerido',
		'cpa.required' => 'Este Campo es Requerido',
		'telefono.required' => 'Este Campo es Requerido',
		'contacto.required' => 'Este Campo es Requerido',
    ];
    }
    public function store(Request $request)
    {
    	$request->validate([
    		'empresa' => 'required',
    		'razon_social' => 'required',
    		'direccion' => 'required',
    		'ciudad' => 'required',
    		'cpa' => 'required',
    		'telefono' => 'required',
    		'contacto' => 'required',
    	]);

        $proveedor = new Proveedor();

        $proveedor->empresa = $request->input('empresa');
        $proveedor->razon_social = $request->input('razon_social');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->ciudad = $request->input('ciudad');
        $proveedor->cpa = $request->input('cpa');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->contacto = $request->input('contacto');

        $proveedor->save();

        return $proveedor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedor = Proveedor::find($id);

        return $proveedor;
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
        $proveedor = Proveedor::find($id);

        $proveedor->empresa = $request->input('empresa');
        $proveedor->razon_social = $request->input('razon_social');
        $proveedor->direccion = $request->input('direccion');
        $proveedor->ciudad = $request->input('ciudad');
        $proveedor->cpa = $request->input('cpa');
        $proveedor->telefono = $request->input('telefono');
        $proveedor->contacto = $request->input('contacto');

        $proveedor->save();

        return $proveedor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proveedor = Proveedor::find($id);

        $proveedor->delete();

        return $proveedor;
    }
}
