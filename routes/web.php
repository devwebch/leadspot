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

Auth::routes();

Route::get('/', 'Controller@home');
Route::get('/contact', function () { return view('contact'); } )->middleware('auth');
Route::post('/contact/send', 'Controller@contactSend');
Route::get('/help', function () { return view('help'); } )->middleware('auth');

// Subscriptions
Route::get('/subscription/new', function () { return view('auth.subscription'); });
Route::post('/subscription/save', 'Controller@addSubscription');
Route::get('/subscription/cancel', 'Controller@removeSubscription');
Route::get('/subscription/error/limit', function () { return view('shared.error_subscription_limit'); });

// Leads
Route::group(['prefix' => 'leads', 'middleware' => 'auth'], function (){
    Route::get('list', 'LeadController@getLeads');
    Route::get('new', 'LeadController@newLead');
    Route::get('search', function () { return view('leads.search'); });
    Route::post('store/{id?}', 'LeadController@storeLead');
    Route::get('delete/{lead}', 'LeadController@deleteLead');
    Route::get('edit/{lead}', 'LeadController@editLead');
    Route::get('view/{lead}', 'LeadController@viewLead');
});

// Service
Route::group(['prefix' => 'service', 'middleware' => 'auth'], function(){
    Route::post('/leads/save', 'LeadServiceController@save');
    Route::post('/leads/getcms', 'LeadServiceController@getCMS');
    Route::post('/subscription/usageGranted', 'SubscriptionServiceController@checkSubscriptionUsage');
    Route::post('/subscription/update', 'SubscriptionServiceController@updateSubscriptionUsage');
});

// User account
Route::group(['prefix' => 'account', 'middleware' => ['auth']], function(){
    Route::get('/', 'UserController@account');
});

Route::get('/logout', 'Auth\LoginController@logout');