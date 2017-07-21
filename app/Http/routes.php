<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Route::get('/', function () {
//     return view('home');    
// });
Route::auth();

Route::group(['middleware' => ['auth']], function () {
	Route::get('/', ['as'=>'inicio','uses'=>function () {
		if(Auth::user()->tipo<2)
		{	
			return view('libro.buscar');
		}
		else 
	   return view('dashboard');

	}]);
	//Gestionar
	Route::get('gestionar',function()
	{
		return view('libro.gestionar');
	});
	//Dashboard
	Route::get('dashboard/{tipo_dia}','PrestamoController@dashboard');
	Route::get('prestamo/grafico/{tipo_grafico}','PrestamoController@grafico');
	Route::get('apidashboard/{tipo}/{fecha}','PrestamoController@datadashboard');
	//Prestamo
	Route::resource('prestamo','PrestamoController');
	Route::get('prestamoDevolver',['as'=>'prestamo.devolver','uses'=>'PrestamoController@devolver']);
	Route::get('api/prestamo','PrestamoController@data');
	Route::get('get/prestamo','PrestamoController@get');
	Route::get('reporte/prestamo/{id}','PrestamoController@reporte');
	Route::get('reporte/prestamo','PrestamoController@reporte_index');
	Route::get('prestamo_busqueda','PrestamoController@indexbusqueda');
	Route::get('prestamo_usuario','PrestamoController@indexusuario');
	//Libro
	Route::resource('libro','LibroController');
	Route::get('reportes/libro','LibroController@reporte');
	Route::get('api/libro','LibroController@data');
	Route::get('api/libro_prestar','LibroController@data_prestar');
	Route::get('get/libro','LibroController@get');
	//categoria
	Route::resource('categoria','CategoriaController');
	Route::get('reportes/categoria','CategoriaController@reporte');
	//autoress
	Route::resource('autor','AutorController');
	Route::get('reportes/autor','AutorController@reporte');
	Route::get('api/autor','AutorController@data');

	Route::get('get/autor','AutorController@get');
	//usuarios
	Route::resource('user','UsuarioController');	
	Route::get('reportes/user_index','UsuarioController@reporte_index');
	Route::get('reportes/user/{tipo}','UsuarioController@reporte');
	Route::get('api/user','UsuarioController@data');
	Route::get('get/user','UsuarioController@get');
	//reporte
	Route::resource('reporte','ReporteController');
	//sancion
	Route::resource('sancion','SancionController');
	//escuela
	Route::get('escuela',function()
	{
		return view('escuela.index');
	});
	

});
