<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperationController;

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

Route::get('/', function () {
    $page = 'home';
    return view('index', compact('page'));
});

Auth::routes(['register' => false]);
//Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::resource('operations', OperationController::class)->except(['show']);
});
