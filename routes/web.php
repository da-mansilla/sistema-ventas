<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', 'HomeController@index')->name('home');

Route::apiResource('products','ProductController');
Route::get('stock','ProductController@stock')->name('products.stock');
Route::get('cantidadProducts','ProductController@cantidadProducts')->name('products.cantidadProducts');
Route::get('temporadas','ProductController@temporadas')->name('products.temporadas');

Route::get('buscarProducto/{serie}','ProductController@buscarProducto')->name('products.buscarProducto');
Route::get('todosproductos','ProductController@todosProductos')->name('products.todosProductos');
Route::post('filtrar','ProductController@filtrar')->name('products.filtrar');
Route::post('informacionFiltro','ProductController@informacionFiltro')->name('products.informacionFiltro');
Route::get('productosPorSerie/{serie}','ProductController@productosPorSerie')->name('products.productosPorSerie');
Route::post('modificarProductos','ProductController@modificarProductos')->name('products.modificarProductos');
Route::post('productsPorCategoria','ProductController@productsPorCategoria')->name('products.productsPorCategoria');

Route::apiResource('ventas','VentaController');
Route::get('ingresos/{fecha}','VentaController@ingresos')->name('ventas.ingresos');
Route::post('datosventas','VentaController@datosVentas')->name('ventas.datosVentas');
Route::get('ventasseña','VentaController@ventasSeña')->name('ventas.ventasSeña');
Route::post('ventasPorFecha','VentaController@ventasPorFecha')->name('ventas.ventasPorFecha');


Route::apiResource('clients','ClientController');


Route::apiResource('categorias','CategoriaController');
Route::get('cantidadcategorias','CategoriaController@cantidadCategorias')->name('categoria.cantidadCategorias');
Route::get('categoriastodas','CategoriaController@categoriasTodas')->name('categoria.categoriasTodas');
Route::get('productsporcategoria/{id}','CategoriaController@productsPorCategoria')->name('categoria.productsPorCategoria');

Route::apiResource('tarjetas','TarjetaController');

Route::apiResource('cuentas','CuentaController');
Route::get('cuentasCantidad','CuentaController@cuentasCantidad')->name('cuenta.cuentasCantidad');
Route::get('cuentasCobrar','CuentaController@cuentasCobrar')->name('cuenta.cuentasCobrar');

Route::apiResource('pagos','PagoController');

Route::put('clients/disable/{id}','ClientController@disable')->name('clients.disable');
Route::get('clientsCuentas','ClientController@clientesCuentas')->name('clients.cuentas');
Route::put('clients/crearcuenta/{id}','ClientController@crearCuenta')->name('clients.crearCuenta');
Route::get('clients/buscar/{nombre}','ClientController@busqueda')->name('clients.busqueda');
Route::get('cantidadClientes','ClientController@cantidadClientes')->name('clients.cantidadClientes');

Route::get('cantidad','ProductController@cantidad')->name('products.cantidad');
Route::put('precio','ProductController@precio')->name('products.precio');

Route::get('tipos/{tipo}','CategoriaController@categoriaTipo')->name('categorias.tipo');

Route::get('productsvendidos/{venta_id}','ProductVendidoController@index')->name('productsvendidos.index');
Route::post('productsvendidos/{venta_id}','ProductVendidoController@save')->name('productsvendidos.save');
Route::post('productsvendidos/{id}','ProductVendidoController@update')->name('productsvendidos.update');
Route::put('finalizarproducto/{id}','ProductVendidoController@finalizarProducto')->name('productsvendidos.finalizarProducto');

Route::get('seriecolor/{codigo}','SerieColorController@index')->name('seriecolor.index');
Route::post('seriecolor','SerieColorController@save')->name('seriecolor.save');

Route::apiResource('proveedors','ProveedorController');

Route::apiResource('cuenta_bancarias','CuentaBancariaController');


