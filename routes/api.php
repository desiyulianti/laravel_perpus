<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//LOGIN REGISTER
Route::post('/Register', 'UserController@register');
Route::post('/Login', 'UserController@login');

Route::middleware(['jwt.verify'])->group(function () {
    Route::get('/login_check','UserController@getAuthenticatedUser');
    Route::group(['middleware' => ['api.superadmin']], function () {

        Route::delete('/Book/{id}', 'BookController@delete');
        Route::delete('/Students/{id}', 'StudentsController@delete');
        Route::delete('/Grade/{id}', 'GradeController@delete');
        Route::delete('/BookBorrow/{id}', 'BookBorrowController@delete');
        Route::delete('/BookReturn/{id}', 'BookReturnController@delete');
        Route::delete('/DetailBookBorrow/{id}', 'DetailBookBorrowController@delete');
    });
    Route::group(['middleware' => ['api.admin']], function () {

        Route::post('/Book', 'BookController@store');
        Route::put('/Book/{id}', 'BookController@update');

        Route::post('/Students', 'StudentsController@store');
        Route::put('/Students/{id}', 'StudentsController@update');

        Route::post('/Grade', 'GradeController@store');
        Route::put('/Grade/{id}', 'GradeController@update');


        Route::post('/BookBorrow', 'BookBorrowController@store');
        Route::put('/BookBorrow/{id}', 'BookBorrowController@update');

        Route::post('BookReturn', 'BookReturnController@returningbook');
        Route::put('/BookReturn/{id}', 'BookReturnController@update');

        Route::post('/DetailBookBorrow', 'DetailBookBorrowController@store');
        Route::put('/DetailBookBorrow/{id}', 'DetailBookBorrowController@update');
    });
});

Route::get('/Book', 'BookController@show');
Route::get('/Book/{id}', 'BookController@detail');

Route::get('/Students', 'StudentsController@show');
Route::get('/Students/{id}', 'StudentsController@detail');

Route::get('/Grade', 'GradeController@show');
Route::get('/Grade/{id}', 'GradeController@detail');

Route::get('/BookBorrow', 'BookBorrowController@show');
Route::get('/BookBorrow/{id}', 'BookBorrowController@detail');

Route::get('/BookReturn', 'BookReturnController@show');
Route::get('/BookReturn/{id}', 'BookReturnController@detail');


Route::get('/DetailBookBorrow', 'DetailBookBorrowController@show');
Route::get('/DetailBookBorrow/{id}', 'DetailBookBorrowController@detail');
