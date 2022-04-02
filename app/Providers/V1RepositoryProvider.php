<?php


namespace App\Providers;

use App\Repositories\V1\Interfaces\TodoRepositoryInterface;
use App\Repositories\V1\TodoRepository;
use Illuminate\Support\ServiceProvider;

class V1RepositoryProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TodoRepositoryInterface::class, TodoRepository::class);
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
