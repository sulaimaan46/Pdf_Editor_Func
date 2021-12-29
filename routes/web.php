<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\PdfController;
use App\Http\Controllers\PdfController;
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
Route::get('/ckeditor', 'App\Http\Controllers\PdfController@index');
Route::get('/pdf/view', 'App\Http\Controllers\PdfController@pdfGenerate');

Route::post('/ckeditor/upload', 'App\Http\Controllers\PdfController@upload')->name('ckeditor.upload');

Route::post('/ckeditor/store', 'App\Http\Controllers\PdfController@store')->name('ckeditor.store');

Route::get('/ckeditor/pdf', 'App\Http\Controllers\PdfController@createPDF');
