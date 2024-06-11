<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth', \App\Http\Middleware\EnsureIsAdmin::class)->group(function () {
    Route::controller(\App\Http\Controllers\Admin\UserController::class)->prefix('users')->group(function () {
        Route::get('/', 'index')->name('users.index');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/store', 'store')->name('users.store');
        Route::get('/{user}', 'show')->name('users.show');
        Route::get('/edit/{user}', 'edit')->name('users.edit');
        Route::put('/update', 'update')->name('users.update');
        Route::delete('/delete/{user}', 'destroy')->name('users.delete');
    });

    Route::controller(\App\Http\Controllers\Admin\ScheduleController::class)->prefix('users/schedule')->group(function () {
        Route::get('/{user}', 'index')->name('admin.schedule.index');
        Route::get('/create/{id}', 'create')->name('admin.schedule.create');
        Route::post('/store', 'store')->name('admin.schedule.store');
        Route::delete('/delete/{schedule}', 'destroy')->name('admin.schedule.delete');
    });

    Route::controller(\App\Http\Controllers\Admin\HomeworkController::class)->prefix('users/homework')->group(function () {
        Route::get('/{user}', 'index')->name('admin.homework.index');
        Route::get('/create/{id}', 'create')->name('admin.homework.create');
        Route::post('/store', 'store')->name('admin.homework.store');
        Route::delete('/delete/{homework}', 'destroy')->name('admin.homework.delete');
    });

    Route::controller(\App\Http\Controllers\Admin\NoteController::class)->prefix('users/note')->group(function () {
        Route::get('/{user}', 'index')->name('admin.note.index');
        Route::get('/create/{id}', 'create')->name('admin.note.create');
        Route::post('/store', 'store')->name('admin.note.store');
        Route::delete('/delete/{note}', 'destroy')->name('admin.note.delete');
    });
});







