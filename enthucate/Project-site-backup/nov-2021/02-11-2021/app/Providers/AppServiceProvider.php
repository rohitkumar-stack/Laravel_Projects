<?php

namespace App\Providers;

use Orchestra\Support\Facades\Tenanti;
use Illuminate\Support\ServiceProvider;
use App\Observers\OrganisationObserver;
use App\Models\Organisation;
class AppServiceProvider extends ServiceProvider{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        Organisation::observe(new OrganisationObserver);
        Tenanti::connection('tenants', function (Organisation $entity, array $config) {
            $config['database'] = "enthucate_{$entity->getKey()}"; 
            return $config;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        //
    }
}