<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewAutoParkСontroller;
use App\Http\Controllers\AdministrationСontroller;
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


//ViewAutoPark
Route::get('/view_autopark/get_clients',[ViewAutoParkСontroller::class,'GetClients']);
Route::get('/view_autopark/get_car',[ViewAutoParkСontroller::class,'GetDefinedCar']);
Route::post('/view_autopark/change_cip',[ViewAutoParkСontroller::class,'ChangeCarInPlace']);
Route::post('/view_autopark/add_car',[ViewAutoParkСontroller::class,'AddCar']);


//Administration
Route::get('/administration/get_car',[AdministrationСontroller::class,'GetClient']);
Route::put('/administration/edit_client_form/edit',[AdministrationСontroller::class,'EditClient'])->name('edit_client');
Route::post('/administration/add_client_form/add',[AdministrationСontroller::class,'AddClient'])->name('add_client');

