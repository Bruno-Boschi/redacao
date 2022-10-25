<?php

use Illuminate\Support\Facades\Mail;

header('Access-Control-Allow-Origin: *');

// if (env('APP_ENV') == 'production') {
//     URL::forceScheme('https');
// }

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

Route::any('/', 'HomeController@anyIndex');
AdvancedRoute::controller('/usuarios', 'Auth\UsuariosController');
AdvancedRoute::controller('/sincronizador', 'Sincronizador\SincronizarController');

Route::group(['prefix' => '/', 'middleware' => []], function () {
    AdvancedRoute::controller('/dashboard', 'Dashboard\DashboardController');
    AdvancedRoute::controller('/configuracoes', 'Configuracoes\ConfiguracoesController');
    AdvancedRoute::controller('/temas', 'Materias\TemasController');
    AdvancedRoute::controller('/faqs', 'Faqs\FaqsController');
    AdvancedRoute::controller('/financeiros', 'Financeiros\FinanceirosController');
    AdvancedRoute::controller('/suportes', 'Suportes\SuportesController');
    AdvancedRoute::controller('/videos', 'Videos\VideosController');
    AdvancedRoute::controller('/materias', 'Materias\MateriasController');
    AdvancedRoute::controller('/dominios', 'Dominios\DominiosController');
    AdvancedRoute::controller('/avisos', 'Avisos\AvisosController');

    //REFERENCIA
    Route::get('/referencias-materias', 'Referencias\ReferenciasMateriasController@getIndex')->name('index');
    Route::get('/referencias-materias/create-edit', 'Referencias\ReferenciasMateriasController@getCreateEdit')->name('getCreateEdit');
    Route::get('/referencias-materias/create-edit/{id}', 'Referencias\ReferenciasMateriasController@getCreateEdit')->name('getCreateEdit');
    Route::post('/referencias-materias/create-edit', 'Referencias\ReferenciasMateriasController@createEdit')->name('createEdit');
    Route::get('/referencias-materias/delete/{id}', 'Referencias\ReferenciasMateriasController@delete')->name('delete');
});
// Route::get('aprovado', function () {

//     return new \App\Mail\acpNewUser($user);
//     // Mail::send(new \App\Mail\acpNewUser($user));
// });



Route::get('/home', 'HomeController@anyIndex')->name('home');

Auth::routes();
