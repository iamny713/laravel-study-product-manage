<?php

use App\Http\Middleware\AuthenticateOnceWithBasicAuth;
use Illuminate\Http\Request;

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

Route::middleware(AuthenticateOnceWithBasicAuth::class)->get('/user', function (Request $request) {
    return [
        'foo' => 'bar',
    ];
});

Route::middleware(AuthenticateOnceWithBasicAuth::class)->group(function () {
    Route::post('products', 'ProductController@createProduct');
    Route::get('products', 'ProductController@listProduct');
    Route::put('products/{product}', 'ProductController@updateProduct');
    Route::delete('products/{product}', 'ProductController@deleteProduct');
});
