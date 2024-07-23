<?php

namespace App\Providers;

use App\Repositories\Contracts\Product\DeleteProductRepositoryInterface;
use App\Repositories\Contracts\Product\GetAllProductRepositoryInterface;
use App\Repositories\Contracts\Product\GetOneProductRepositoryInterface;
use App\Repositories\Contracts\Product\RegisterProductRepositoryInterface;
use App\Repositories\Contracts\Product\UpdateProductRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\EloquentUserRepository;
use App\Repositories\Product\EloquentDeleteProductRepository;
use App\Repositories\Product\EloquentGetAllProductRepository;
use App\Repositories\Product\EloquentGetOneProductRepository;
use App\Repositories\Product\EloquentRegisterProductRepository;
use App\Repositories\Product\EloquentUpdateProductRepository;
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

        $this->app->bind(RegisterProductRepositoryInterface::class, EloquentRegisterProductRepository::class);
        $this->app->bind(DeleteProductRepositoryInterface::class, EloquentDeleteProductRepository::class);
        $this->app->bind(GetAllProductRepositoryInterface::class, EloquentGetAllProductRepository::class);
        $this->app->bind(GetOneProductRepositoryInterface::class, EloquentGetOneProductRepository::class);
        $this->app->bind(UpdateProductRepositoryInterface::class, EloquentUpdateProductRepository::class);
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
