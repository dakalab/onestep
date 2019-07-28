<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Log SQL
        if (config('app.debug')) {
            DB::listen(function ($query) {
                $bindings = $query->bindings;
                foreach ($bindings as &$binding) {
                    $binding = is_numeric($binding) ? $binding : "'" . $binding . "'";
                }
                $sql = str_replace_array('?', $bindings, $query->sql);
                Log::channel('db')->debug($sql . '; [' . $query->time . 'ms]');
            });
        }

        if (!session('currency')) {
            session(['currency' => config('app.currency')]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
