<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\NewsApiController;
use App\Http\Controllers\API\UserController;
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
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('/news', [NewsApiController::class, 'getNews']);
Route::get('/news/{category}', [NewsApiController::class, 'getNewsbyCategories']);
Route::get('/newsbyAuthor/{authorName}', [NewsApiController::class, 'getNewsbyAuthor']);
Route::get('/news/{category}/{authorName}', [NewsApiController::class, 'filterByCategoryandAuthor']);
Route::get('/author', [NewsApiController::class, 'getAuthor']);
Route::get('/author/{category}', [NewsApiController::class, 'getAuthorbycategory']);
Route::get('/NYTnews', [NewsApiController::class, 'nytNews']);
Route::get('/NYTnews/{category}', [NewsApiController::class, 'nytNewsbyCategory']);




