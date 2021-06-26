<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('/personas/signUp', 'PersonaController@signUp');

$router->post('/personas/signIn', 'PersonaController@signIn');

$router->get('/llamados/buscarLlamados', 'LlamadoController@buscarLlamados');

$router->get('/llamados/buscarUltimasVacantes', 'LlamadoController@buscarUltimasVacantes');

$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->get('/personas/perfil', 'PersonaController@perfil');

    $router->post('/personas/editarPerfil', 'PersonaController@editarPerfil');

    $router->post('/personas/actualizarCV', 'PersonaController@actualizarCV');

    $router->get('/llamados/buscarLlamadosAAdministrar', 'LlamadoController@buscarLlamadosAAdministrar');

    $router->group(['middleware' => ['authAdmin']], function () use ($router) {
        $router->post('/llamados/agregarLlamado', 'LlamadoController@agregarLlamado');

        $router->post('/llamados/editarLlamado/{id_llamado}', 'LlamadoController@editarLlamado');

        $router->delete('/llamados/eliminarLlamado/{id_llamado}', 'LlamadoController@eliminarLlamado');
    });

    $router->group(['middleware' => ['authJefeCatedra']], function () use ($router) {
        
    });

    $router->group(['middleware' => ['authUsuario']], function () use ($router) {
        $router->get('/postulaciones/buscarPostulacionesDelUsuario', 'PostulacionController@buscarPostulacionesDelUsuario');
    
        $router->post('/postulaciones/agregarPostulacionDelUsuario', 'PostulacionController@agregarPostulacionDelUsuario');
    
        $router->delete('/postulaciones/eliminarPostulacionDelUsuario/{id_llamado}', 'PostulacionController@eliminarPostulacionDelUsuario');
    });

    $router->group(['middleware' => ['calificarLlamado']], function () use ($router) {
        $router->post('/llamados/calificarLlamado', 'LlamadoController@calificarLlamado');
    });

    $router->group(['middleware' => ['buscarLlamado']], function () use ($router) {
        $router->get('/llamados/buscarLlamado/{id_llamado}', 'LlamadoController@buscarLlamado');
    });
});
