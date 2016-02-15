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

Route::get('/', [
    'as'   => 'home',
    'uses' => 'GamersController@index'
]);

Route::get('/clips', [
    'as'   => 'clips',
    'uses' => 'ClipsController@index'
]);

Route::get('/clips/{clip_id}', [
    'as'   => 'clip',
    'uses' => 'ClipsController@clip'
]);

Route::get('/{gamertag}', [
    'as'   => 'member',
    'uses' => 'GamersController@show'
]);

Route::get('/{gamertag}/clips', [
    'as'   => 'member.clips',
    'uses' => 'ClipsController@clipsForGamertag'
]);

Route::get('/{gamertag}/clips/{clip_id}', [
    'as'   => 'member.clip',
    'uses' => 'ClipsController@clipForGamertag'
]);

// Redirect routes to handle some of the older routes

Route::get('/members', function () {
    return redirect('/');
});

Route::get('/members/{gamer}', function ($gamertag) {
    return redirect()->route('member', ['gamertag' => $gamertag]);
});
