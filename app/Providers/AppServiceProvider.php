<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentUserRepository;
use App\Services\Contracts\EncryptionInterface;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\JsonBasicResponse;
use App\Services\LaravelHashEncryption;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(JsonResponseInterface::class, JsonBasicResponse::class);
        $this->app->bind(EncryptionInterface::class, LaravelHashEncryption::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
