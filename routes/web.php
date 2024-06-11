<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
    ]);
});



Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', \App\Http\Controllers\User\DashboardController::class)->name('dashboard');
    Route::get('/schedules', \App\Http\Controllers\User\ScheduleController::class)->name('schedules');
    Route::get('/homeworks', \App\Http\Controllers\User\HomeworkController::class)->name('homeworks');
    Route::get('/notes', \App\Http\Controllers\User\NoteController::class)->name('notes');

    Route::get('/homework/file/{file_id}', \App\Http\Controllers\FileController\HomeworkController::class)->where('filename', '.*')->name('homework.file.show');
    Route::get('/note/file/{file_id}', \App\Http\Controllers\FileController\NoteController::class)->where('filename', '.*')->name('note.file.show');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
