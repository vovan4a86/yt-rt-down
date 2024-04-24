<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/ytdlp', [PageController::class, 'ytdlp']);
Route::post('/get-name', [PageController::class, 'getName']);
Route::post('/get-file', [PageController::class, 'getFile']);
Route::post('/delete-files', [PageController::class, 'deleteFiles']);
