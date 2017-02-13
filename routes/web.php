<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('login', 'LoginController@index');

Route::post('login', 'LoginController@login');

Route::any('logout', function() {

    \Auth::logout();

    request()->session()->flush();
    request()->session()->regenerate();

    return redirect('login');
});

Route::get('/', 'StorageController@index')->name('dashboard');

Route::get('files', 'StorageController@files')->name('files');

Route::get('trash', 'StorageController@trash')->name('trash');

Route::get('file/{id}', 'StorageController@file')->name('file');

Route::post('file/{id}/delete', 'StorageController@delete')->name('delete');

Route::any('file/{id}/deleteforever', 'StorageController@deleteForever')->name('deleteforever');

Route::any('file/{id}/restore', 'StorageController@restore')->name('restore');

Route::get('file/{id}/download', 'StorageController@download')->name('download');

Route::get('file/{id}/view', 'StorageController@view')->name('view');

Route::post('file/{id}/share', 'StorageController@share')->name('share');

Route::get('upload', 'StorageController@uploadPage');

Route::post('upload', 'StorageController@upload');

Route::get('people', 'UserController@all')->name('people');

Route::get('settings', 'UserController@settings')->name('settings');

Route::post('settings/photo', 'UserController@photo')->name('userphoto');

Route::post('settings/password', 'UserController@password')->name('userpassword');
