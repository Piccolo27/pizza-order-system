<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('allData/list',[RouteController::class,'allDataList']);
Route::post('category/create',[RouteController::class,'categoryCreate']);
Route::post('create/contact',[Routecontroller::class,'createContact']);
Route::post('category/delete',[RouteController::class,'deleteCategory']);
Route::post('category/details',[RouteController::class,'categoryDetails']);
Route::post('category/update',[RouteController::class,'categoryUpdate']);
