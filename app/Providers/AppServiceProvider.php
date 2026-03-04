<?php

namespace App\Providers;

use App\Repositories\Contracts\MatrixClosureRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\WalletRepositoryInterface;
use App\Repositories\Eloquents\MatrixClosureRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\WalletRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    
        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletRepository::class
        );
    
        $this->app->bind(
            MatrixClosureRepositoryInterface::class,
            MatrixClosureRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
