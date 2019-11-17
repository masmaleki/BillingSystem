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
    return redirect(app()->getLocale());
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'], function() {

    Route::get('/', function () {
        return redirect()->route('home',app()->getLocale());
    })->name('main');

    Auth::routes([
        'register' => false
    ]);

    Route::get('/home', 'HomeController@index')->name('home');


    /////////// CLIENT ROUTES //////////////// START/////////////

    Route::get('/clients', 'ClientController@showClients')->name('clients');
    Route::get('/clients/new', 'ClientController@createClient')->name('createClient');
    Route::post('/clients/new/create', 'ClientController@doCreateClient')->name('doCreateClient');
    Route::get('/clients/payments/{id}', 'ClientController@paymentHistory')->name('paymentHistory');

    /////////// CLIENT ROUTES //////////////// END///////////////

    /////////// USER ROUTES //////////////// START///////////////

    Route::get('/users', 'userController@showUsers')->name('users');
    Route::get('/users/new', 'userController@createUser')->name('createUser');
    Route::post('/users/new/create', 'userController@doCreateUser')->name('doCreateUser');
    Route::get('/users/delete/{id}', 'userController@deleteUser')->name('deleteUser');
    Route::get('/users/edit/{id}', 'userController@editUser')->name('editUser');
    Route::post('/users/edit/{id}/action', 'userController@doEditUser')->name('doEditUser');
    Route::get('/users/changePassword', function () {
        return view('auth.passwords.change');
    })->name('changePassword');
    Route::post('/users/changePassword/action', 'userController@doChangePassword')->name('doChangePassword');

    /////////// USER ROUTES //////////////// END///////////////
    /////////// PAYMENT ROUTES //////////////// START/////////////

    Route::get('/payments', 'PaymentController@showPayments')->name('payments');
    Route::get('/payments/new', 'PaymentController@createPayment')->name('createPayment');
    Route::post('/payments/new/create', 'PaymentController@doCreatePayment')->name('doCreatePayment');
    Route::get('/payments/delete/{id}', 'PaymentController@deletePayment')->name('deletePayment');


    /////////// PAYMENT ROUTES //////////////// END///////////////
});
Route::post('/payments/search', 'PaymentController@paymentSearch')->name('paymentSearch');
Route::post('/client/search', 'ClientController@clientSearch')->name('clientSearch');
