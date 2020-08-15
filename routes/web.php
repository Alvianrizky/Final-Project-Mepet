<?php

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

Route::get('/jawaban/{id}', 'PertanyaanController@jawaban');

Route::get('/form', 'PertanyaanController@create');
Route::post('/', 'PertanyaanController@store');
Route::get('/', 'PertanyaanController@index')->name('index');
Route::get('/detail/{id}', 'PertanyaanController@show');
Route::post('/detail/{id}/pertanyaan', 'KomentarPerController@store');
Route::post('/detail/{id}', 'JawabanController@store');
Route::post('/detail/{id}/jawaban', 'KomentarJawController@store');

Route::get('/up/{id}', 'PertanyaanController@up');
Route::get('/down/{id}', 'PertanyaanController@down');

Route::get('/upper/{id}', 'JawabanController@upper');
Route::get('/downper/{id}', 'JawabanController@downper');

Route::get('/up/{id}/jawaban', 'JawabanController@up');
Route::get('/down/{id}/jawaban', 'JawabanController@down');

Route::get('/edit/{id}/pertanyaan', 'PertanyaanController@edit');
Route::delete('/delete/{id}/pertanyaan', 'PertanyaanController@destroy');
Route::put('/update/{id}/pertanyaan', 'PertanyaanController@update');

Route::get('/edit/{id}/jawaban', 'JawabanController@edit');
Route::delete('/delete/{id}/jawaban', 'JawabanController@destroy');
Route::put('/update/{id}/jawaban', 'JawabanController@update');

Route::get('/edit/{id}/komentarpertanyaan', 'KomentarPerController@edit');
Route::get('/delete/{id}/komentarpertanyaan', 'KomentarPerController@destroy');
Route::put('/update/{id}/komentarpertanyaan', 'KomentarPerController@update');

Route::get('/edit/{id}/komentarjawaban', 'KomentarJawController@edit');
Route::get('/delete/{id}/komentarjawaban', 'KomentarJawController@destroy');
Route::put('/update/{id}/komentarjawaban', 'KomentarJawController@update');

Route::get('/profile', 'ProfileController@create')->name('profile');
Route::post('/profile/save', 'ProfileController@store');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
