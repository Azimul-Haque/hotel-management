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
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('key:generate');
    echo 'All done!';
    // return what you want
});
Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);
Route::get('/dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

// blackouts...
Route::get('/dashboard/blackouts', ['as' => 'dashboard.blackout', 'uses' => 'DashboardController@getBlackouts']);
Route::post('/dashboard/blackouts', ['as' => 'dashboard.blackout.store', 'uses' => 'DashboardController@storeBlackouts']);
Route::put('/dashboard/blackouts/{id}', ['as' => 'dashboard.blackout.update', 'uses' => 'DashboardController@updateBlackouts']);
Route::delete('/dashboard/blackouts/{id}', ['as' => 'dashboard.blackout.delete', 'uses' => 'DashboardController@deleteBlackouts']);
// blackouts...


// reservations...
Route::post('/reservation/store', ['as' => 'reservation.store', 'uses' => 'ReservationController@store']);
Route::post('/reservation/update', ['as' => 'reservation.update', 'uses' => 'ReservationController@update']);
Route::get('/reservation/vacant/{id}', ['as' => 'reservation.delete', 'uses' => 'ReservationController@delete']);
Route::delete('/reservation/vacant/{id}', ['as' => 'reservation.destroy', 'uses' => 'ReservationController@destroy']);

// reservations api...
Route::get('/reservation/yesterday/getdata/{unique_key}/{date}', ['as' => 'reservation.getdata.api', 'uses' => 'ReservationController@getYesterdayDataAPI']);
// reservations api...
// reservations...

// monthly statement
Route::get('/dashboard/statement', ['as' => 'dashboard.statement', 'uses' => 'DashboardController@getStement']);
Route::get('/dashboard/statement/range/pdf', ['as' => 'dashboard.rangestatement', 'uses' => 'DashboardController@getRangePDF']);
Route::get('/dashboard/statement/month/pdf', ['as' => 'dashboard.monthstatement', 'uses' => 'DashboardController@getMonthPDF']);
Route::get('/dashboard/statement/roomwise/pdf', ['as' => 'dashboard.roomwisetatement', 'uses' => 'DashboardController@getRoomWisePDF']);
// monthly statement

Route::auth();

Route::resource('users','UserController');
Route::get('/profile', ['as' => 'dashboard.profile', 'uses' => 'UserController@getProfile']);