<?php

use App\Http\Controllers\API\V1\TodoController as TodoControllerV1;
use App\Http\Controllers\API\V2\TodoController as TodoControllerV2;

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

Route::group(["prefix" => "v1"], function () {
    Route::group(["prefix" => "todo"], function () {
        Route::get("/get/{id}", [TodoControllerV1::class, "get"]);
        Route::get("/gets", [TodoControllerV1::class, "gets"]);
        Route::post("/store", [TodoControllerV1::class, "store"]);
        Route::put("/update/{id}", [TodoControllerV1::class, "update"]);
        Route::delete("/delete/{id}", [TodoControllerV1::class, "delete"]);
    });
});

Route::group(["prefix" => "v2"], function () {
    Route::group(["prefix" => "todo"], function () {
        Route::get("/get/{id}", [TodoControllerV2::class, "get"]);
        Route::get("/gets", [TodoControllerV2::class, "gets"]);
        Route::post("/store", [TodoControllerV2::class, "store"]);
        Route::put("/update/{id}", [TodoControllerV2::class, "update"]);
        Route::delete("/delete/{id}", [TodoControllerV2::class, "delete"]);
    });
});