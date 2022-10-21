<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('all-datas/list',[RouteController::class,'allDataList']);
Route::post('categories/create',[RouteController::class,'categoryCreate']);
Route::post('contacts/create',[Routecontroller::class,'createContact']);
Route::post('categories/delete',[RouteController::class,'deleteCategory']);
Route::post('categories/details',[RouteController::class,'categoryDetails']);
Route::post('categories/update',[RouteController::class,'categoryUpdate']);
