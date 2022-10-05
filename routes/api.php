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

Route::get('list','App\Http\Controllers\GTM_call@list');

Route::get('account/{account_id?}','App\Http\Controllers\GTM_call@account');

Route::get('account/{account_id}/container/{container_id?}','App\Http\Controllers\GTM_call@container');

Route::get('account/{account_id}/container/{container_id}/workspace/{workspace_id?}','App\Http\Controllers\GTM_call@workspace');