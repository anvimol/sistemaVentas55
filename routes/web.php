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

Route::get('/', function () {
    return view('auth/login');
});

Route::resource('almacen/categoria','CategoryController');
Route::resource('almacen/articulo', 'ArticleController');
Route::resource('compras/proveedor', 'ProviderController');
Route::resource('compras/ingreso', 'IngresoController');
Route::resource('ventas/cliente', 'ClientController');
Route::resource('ventas/venta', 'VentaController');

Route::resource('seguridad/usuario', 'UserController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{slug}', 'HomeController@index');
