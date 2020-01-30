<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;


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
        Schema::defaultStringLength(191);
        //dd($this->app->environment());
        if($this->app->environment() == 'local')
        {
            DB::listen(function (QueryExecuted $query){
                file_put_contents('php://stdout', "\e[34m{$query->sql}\t\e\[37m" . json_encode($query->bindings) . "\t\e[32m{$query->time}ms\e[0m\n");
            });
        }
    }
}
