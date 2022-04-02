<?php


namespace App\Providers;

use App\Repositories\V2\Interfaces\TodoRepositoryInterface;
use App\Repositories\V2\TodoRepository;
use Illuminate\Support\ServiceProvider;

class V2RepositoryProvider extends ServiceProvider
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
