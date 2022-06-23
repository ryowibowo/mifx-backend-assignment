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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books', 'BooksController@index');
Route::post('/books', 'BooksController@store')->middleware(['auth','auth.admin']);
Route::post('/books/{book}/reviews', 'BooksReviewController@store');
Route::delete('/books/{book}/reviews/{review}', 'BooksReviewController@destroy');
