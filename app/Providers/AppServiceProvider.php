<?php

namespace App\Providers;

use App\Exceptions\ValidateErrorFormatException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ExceptionHandler::class,
            ValidateErrorFormatException::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        Model::unguard();

        JsonResource::withoutWrapping();

    }
}
