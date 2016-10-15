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
Route::get('/home', function (){ return redirect('/'); });
Route::get('/contact', function () {
    return view('contact');
})->middleware('auth');
Route::post('/contact/send', 'Controller@contactSend');
Route::get('/help', function () { return view('help'); })->middleware('auth');
Route::get('/logout', 'Auth\LoginController@logout');

// Subscriptions
Route::get('/subscribe/{plan}', 'SubscriptionController@subscribe');
Route::get('/subscribe/transaction/success', function () { return view('subscriptions.success'); });

// Leads
Route::group(['prefix' => 'leads', 'middleware' => 'auth'], function () {
    Route::get('list', 'LeadController@getLeads');
    Route::get('new', 'LeadController@newLead');
    Route::get('search', 'LeadController@searchLead');
    Route::post('store/{id?}', 'LeadController@storeLead');
    Route::get('delete/{lead}', 'LeadController@deleteLead');
    Route::get('edit/{lead}', 'LeadController@editLead');
    Route::get('view/{lead}', 'LeadController@viewLead');
    Route::get('report/{lead}', 'LeadController@report');
    Route::get('getcontacts/{lead}', 'LeadServiceController@getLeadEmails');
});

// Service
Route::group(['prefix' => 'service', 'middleware' => 'auth'], function () {
    Route::post('/leads/save', 'LeadServiceController@save');
    Route::post('/leads/getcms', 'LeadServiceController@getCMS');
    Route::post('/subscription/usageGranted', 'SubscriptionServiceController@checkSubscriptionUsage');
    Route::post('/subscription/update', 'SubscriptionServiceController@updateSubscriptionUsage');
    Route::post('/subscription/new/{plan}', 'SubscriptionServiceController@addSubscription');
    Route::get('/subscription/cancel', 'SubscriptionServiceController@removeSubscription');
    Route::post('/subscription/permissions', 'SubscriptionServiceController@getSubscriptionPermissions');

    Route::get('/leads/radar', 'LeadServiceController@getPlacesSample');
    Route::get('/leads/details', 'LeadServiceController@getPlaceDetails');

    Route::post('/user/set/preferences', 'UserController@savePreference');
    Route::post('/user/get/preferences', 'UserController@getPreferences');
});

// User account
Route::group(['prefix' => 'account', 'middleware' => ['auth']], function () {
    Route::get('/', 'UserController@account');
    Route::get('/edit', 'UserController@edit');
    Route::post('/save', 'UserController@save');
    Route::get('/invoice/{invoice}', 'UserController@downloadInvoice');
});

// Admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin@home');
    Route::get('/accounts', 'Admin@accounts');
    Route::get('/subscriptions', 'Admin@subscriptions');
    Route::get('/messages', 'Admin@messages');
    Route::get('/messages/delete/{id}', 'Admin@deleteMessage');
    Route::get('/accounts/login/as/{id}', 'Admin@loginAsUserID');
    Route::get('/accounts/delete/{id}', 'Admin@deleteAccount');
});

// Stripe
Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');