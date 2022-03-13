<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {
    Route::resource('/pessoas', 'PessoaController');
    // Route::get('/pessoas', 'PessoaController@index')->name('index');
    // Route::get('pessoas/delete', 'PessoaController@delete')->name('delete');
    // Route::get('pessoas/edit', 'PessoaController@edit')->name('editar');
    // Route::post('pessoas/create', 'PessoaController@store')->name('store');
    // Route::put('pessoas/edit/{id}', 'PessoaController@update')->name('update');
    // Route::delete('pessoas/deleteon', 'PessoaController@deleteon')->name('deleteon');
});