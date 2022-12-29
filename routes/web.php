<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;

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

Route::get('/contacts', [ExportController::class, 'contacts']);
Route::get('/contact/{name}', [ExportController::class, 'contact']);
Route::get('/contact/{name}/exportvcf', [ExportController::class, 'vcf']);



Route::get('{any}', function () {
    return view('app');
})->where('any','.*');
