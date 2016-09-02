<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'Controller@home');

Route::group(['prefix' => 'leads', 'middleware' => 'auth'], function (){
    Route::get('list', 'LeadController@getLeads');
    Route::get('new', 'LeadController@newLead');
    Route::get('search', function () { return view('leads.search'); });
    Route::post('store/{id?}', 'LeadController@storeLead');
    Route::get('delete/{lead}', 'LeadController@deleteLead');
    Route::get('edit/{lead}', 'LeadController@editLead');
    Route::get('view/{lead}', 'LeadController@viewLead');
});

Route::group(['prefix' => 'service', 'middleware' => 'auth'], function(){
    Route::post('/leads/save', 'LeadServiceController@save');
});

Route::group(['prefix' => 'account', 'middleware' => 'auth'], function(){
    Route::get('/', function (){ return view('auth.account.user'); });
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');