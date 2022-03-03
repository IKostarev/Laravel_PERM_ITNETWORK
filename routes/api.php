<?php

use App\Http\Controllers\Api\CitiesController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Models\Cities;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('cache', function() {
    // Добавление
    //cache()->put('test', 'value');

    /*
    Инкремент/декремент
    cache()->put('count', 123);
    cache()->increment('count', 4);
    cache()->increment('count');
    cache()->decrement('count');
    */

    // Удалить из кэша
    // cache()->forget('test');

    // Сохранить навсегда
    // Cache::forever('forever', 'forever');

    // Очистить весь кэщ
    // cache()->flush();

    // Получить данные из кэша
    $test = cache()->get('test');

    // Пример использования. Если значение в кэше есть - remember вернёт это значение
    // Если значения нет, то выполнится замыкание, а результат добавится в кэш
    return response()->json(
        cache()->remember('cities',84600, function () {
            Log::channel('daily')->info('no cache');
            $repository = new CityRepository();
            return $repository->getAll();
        })
    );
});

Route::group(['prefix' => 'storage'], function () {
    // Загрузка изображения
    Route::post('upload', function(Request $request) {
        $file = $request->file('file');
        return $file->store('test');
    });

    // Скачивание
    Route::get('download/{fileName}', function($fileName) {
        return Storage::download('test/' . $fileName);
    });

    // Удаление файла
    Route::delete('{fileName}', function($fileName) {
        return Storage::delete('test/' . $fileName);
    });
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::get('failed_job', function() {
    \App\Jobs\FailedJob::dispatch();
});

Route::get('notification', function() {
    \App\Events\UserCreatedEvent::dispatch();
});

Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::group(['prefix' => 'cities'], function () {
        Route::get('', [CitiesController::class, 'index']);
        Route::post('', [CitiesController::class, 'store'])->middleware('can:create,' . Cities::class);
        Route::get('{city_id}', [CitiesController::class, 'show']);
        Route::put('{city}', [CitiesController::class, 'update'])->middleware('can:update,city');
        Route::delete('{city_id}', [CitiesController::class, 'destroy']);
        Route::post('restore/{city_id}', [CitiesController::class, 'restore']);
    });
});


