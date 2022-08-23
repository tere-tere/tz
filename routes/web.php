<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministrationСontroller;
use App\Http\Controllers\ViewAutoParkСontroller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function(){

    Route::get('/administration',[AdministrationСontroller::class,'GetPanelAdministration']);

    Route::post('/administration/edit_client_form',[AdministrationСontroller::class,'EditClientForm'])->name('edit_client_form');
    Route::get('/administration/edit_client_form/edit',[AdministrationСontroller::class,'EditClient'])->name('edit_client');
    
    Route::post('/administration/add_client_form',[AdministrationСontroller::class,'AddClientForm'])->name('add_client_form');
    Route::get('/administration/add_client_form/add',[AdministrationСontroller::class,'AddClient'])->name('add_client');
    
    Route::post('/administration/delete',[AdministrationСontroller::class,'DelClient'])->name('del_client');
        
    ///autopark
    Route::get('/view_autopark',[ViewAutoParkСontroller::class,'ViewAutoPark']);
    Route::get('/view_autopark/get_car',[ViewAutoParkСontroller::class,'GetDefinedCar'])->name('get_car');
    Route::post('/view_autopark/change_cip',[ViewAutoParkСontroller::class,'ChangeCarInPlace'])->name('change_cip');
    Route::post('/view_autopark/add_car',[ViewAutoParkСontroller::class,'AddCar'])->name('add_car');
    
    
    Route::get('/', function () {
        return redirect('administration'); //view('dashboard');
    })->name('dashboard');
    
});


require __DIR__.'/auth.php';
