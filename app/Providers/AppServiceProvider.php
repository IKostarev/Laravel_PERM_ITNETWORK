<?php

namespace App\Providers;

use App\Http\Controllers\Api\CitiesController;
use App\Mediators\CityMediator;
use App\Mediators\SingleMediator;
use App\Repositories\CityRepository;
use App\Repositories\Repository;
use App\Services\CityService;
use App\Services\Service;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Вариант 1 - простое связывание
        /*$this->app->bind(CityMediator::class, function($app) {
            return new CityMediator($app->make(CityRepository::class), $app->make(CityService::class));
        });*/

        // Вариант 2 - простое связывание с дополнительной вложенностью
        /*$this->app->bind(CitiesController::class, function($app) {
            $mediator = new SingleMediator($app->make(CityRepository::class), $app->make(CityService::class));
            return new CitiesController($mediator);
        });*/
        $this->app->when([CitiesController::class, SingleMediator::class])
            ->needs(Repository::class)
            ->give(function () {
                return app(CityRepository::class);
            });
        $this->app->when([CitiesController::class, SingleMediator::class])
            ->needs(Service::class)
            ->give(function () {
                return app(CityService::class);
            });

        // Синглтон
       /* $this->app->singleton(CitiesController::class, function($app) {
            $mediator = new SingleMediator($app->make(CityRepository::class), $app->make(CityService::class));
            return new CitiesController($mediator);
        });*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Выполняется до запуска обработки
        \Queue::before(function (JobProcessing $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
            \Log::info($event->connectionName);
        });

        // Выполняется после завершения обработки
        \Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
            \Log::info($event->connectionName);
        });

        // Выполняется при падении задания
        \Queue::failing(function (JobFailed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
            \Log::info($event->connectionName);
        });
    }
}
