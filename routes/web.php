<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Работа с сессией
Route::get('session', function(\Illuminate\Http\Request $request) {
    $request->session()->put('test', '123123');
    return $request->session()->get('test');
});

// Работа с куками
Route::get('cookie', function(\Illuminate\Http\Request $request) {
    // Этот метод корректно работает, просто ларавель по умолчанию некоторые данные в куках шифрует
    // Собственные куки (которые созданы на сайте) можно устанавливать и получать, а вот все остальные - по умолчанию нельзя
    // Для их получения либо отключить \App\Http\Middleware\EncryptCookies::class из web middleware
    // Либо в классе EncryptCookies в $except указать, какие ключи в куках не шифровать

    // Получить куку
    //return $request->cookie('TEST');

    // Все куки из запроса
    // $request->cookies

    // Вернуть ответ и добавить куки
    return response()
        ->json()
        ->cookie('TEST', '12', 60)
        ->cookie('TEST2', '34', 60);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
