<?php

namespace App\Providers;

use App\Interfaces\AccountRepositoryInterface;
use App\Interfaces\BankNoteRepositoryInterface;
use App\Interfaces\TransactionInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AccountRepository;
use App\Repositories\BankNoteRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
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
    //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        $this->app->bind(BankNoteRepositoryInterface::class, BankNoteRepository::class);
        $this->app->bind(TransactionInterface::class, TransactionRepository::class);


    }
}
