<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/hello', function () {
    return 'Xin chào Laravel 12!';
});

Route::view('/', 'home')->name('home');

Route::get('/time', function () {
    return now()->format('H:i:s d/m/Y');
});

Route::get('/sum/{a}/{b}', function ($a, $b) {
    if (! is_numeric($a) || ! is_numeric($b)) {
        return response('Argument must be integer', 400);
    }

    return (int) $a + (int) $b;
});

Route::get('/students', [StudentController::class, 'index'])->name('students.static');

Route::get('/students/db', [StudentController::class, 'indexDb'])->name('students.db');

Route::get('/students/combined', [StudentController::class, 'combine'])->name('students.combined');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
Route::post('/students', [StudentController::class, 'store'])->name('students.store');
