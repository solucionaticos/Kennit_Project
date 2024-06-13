<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\JsonResponseInterface;
use App\Services\Contracts\ValidationUserInterface;
use App\Services\Contracts\EncryptionInterface;

use App\Repositories\UserRepository;
use App\Services\JsonResponseSer;
use App\Services\ValidationUserSer;
use App\Services\EncryptionSer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(JsonResponseInterface::class, JsonResponseSer::class);
        $this->app->bind(ValidationUserInterface::class, ValidationUserSer::class);
        $this->app->bind(EncryptionInterface::class, EncryptionSer::class);
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
