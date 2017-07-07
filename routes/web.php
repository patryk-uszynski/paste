<?php

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

// $app->get('/', function () use ($app) {
//     return $app->version();
// });

$app->get('/', function() use ($app) {
    return view('index');
});

$app->get('api/paste', 'PasteController@index');
$app->post('api/paste', 'PasteController@store');
$app->delete('api/paste/{id}', 'PasteController@destroy');