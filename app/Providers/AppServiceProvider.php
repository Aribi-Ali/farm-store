<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\StorageService;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        // $this->app->singleton(StorageService::class);
        // $this->app->singleton(CategoryService::class);
        // $this->app->singleton(ProductSeeder::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::unguard();
        // Model::shouldBeStrict();
        // URL::forceScheme("https");
        // Vite::usePrefetchStrategy("aggressive");
        // Passport::ignoreRoutes();


        // passport::personalAccessClient();
        // Passport::personalAccessClientSecret(config('CLIENT_SECRET'));

        // Passport::personalAccessClientId(config('ID'));

        // Passport::hashClientSecrets();
        // Passport::tokensCan([
        //     'user-management' => 'Manage user account',
        // ]);

        // Passport::setDefaultScope([
        //     'user-management'
        // ]);
    }
}