<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    $files  = Storage::cloud()->allFiles('test');
    return view('welcome')->with(['files' => $files]);
})->name('home');

Route::post('/', function (Request $request) {
    $file = $request->file('file');

    $file_extension=$file->extension();
    $filename = time() . '.' . $file_extension;

    Storage::cloud()->put('test/' . $filename, (string) file_get_contents($file), 'public');
    return redirect()->route('home');
})->name('send-file');

