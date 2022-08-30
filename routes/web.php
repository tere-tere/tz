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

    Route::get('/administration/edit_client_form/{id}',[AdministrationСontroller::class,'EditClientForm'])->name('edit_client_form');

    Route::get('/administration/add_client_form',[AdministrationСontroller::class,'AddClientForm'])->name('add_client_form');

    Route::get('/administration/delete/{id}',[AdministrationСontroller::class,'DelCarClient'])->name('del_client');

    ///autopark
    Route::get('/view_autopark',[ViewAutoParkСontroller::class,'ViewAutoPark']);

    Route::get('/', function () {
        return redirect('administration'); //view('dashboard');
    })->name('dashboard');

});


require __DIR__.'/auth.php';
