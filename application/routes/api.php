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

Route::group(['prefix' => 'admin'], function () {
    Route::get('get-all-current-carts', function () {
        $r = [];
        foreach (\Illuminate\Support\Facades\DB::table('sessions')->get() as $session) {
            $r[] =  unserialize(base64_decode($session->payload))['cart'] ?? null;
        }
        return ['count' => count($r), 'user_carts' => $r ];
    });

    Route::delete('destroy-all-sessions', function () {
        DB::table('sessions')->truncate();
    });
});

Route::group(['prefix' => 'v1'], function () {
    Route::delete('cart', [App\Http\Controllers\Api\V1\CartController::class, 'clear'])->middleware('web');
    Route::resource('cart', App\Http\Controllers\Api\V1\CartController::class)->middleware('web');
    Route::resource('products', App\Http\Controllers\Api\V1\ProductController::class);
});
