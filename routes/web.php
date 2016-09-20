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

// Standard pages
Route::get('/', 'Controller@home');
Route::get('/contact', function () { return view('contact'); } )->middleware('auth');
Route::post('/contact/send', 'Controller@contactSend');
Route::get('/help', function () { return view('help'); } )->middleware('auth');
Route::get('/logout', 'Auth\LoginController@logout');

// Subscriptions
Route::get('/subscribe/{plan}', 'SubscriptionController@subscribe' );
Route::get('/subscribe/transaction/success', function () { return view('subscriptions.success'); } );

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
    Route::post('/subscription/new/{plan}', 'SubscriptionServiceController@addSubscription');
    Route::get('/subscription/cancel', 'SubscriptionServiceController@removeSubscription');
    Route::post('/subscription/permissions', 'SubscriptionServiceController@getSubscriptionPermissions');
});

// User account
Route::group(['prefix' => 'account', 'middleware' => ['auth']], function(){
    Route::get('/', 'UserController@account');
});

// Stripe
Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');