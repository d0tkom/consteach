<?php

namespace App\Providers;

use App\Http\Services\Alloweds;
use App\Http\Services\Categories;
use App\Http\Services\Owners;
use \Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Request::macro('subdomain', function () {
            $domain = request()->server->get('HTTP_HOST');
            $split = explode('.', $domain);

            return array_get($split, '0', '');
        });
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
