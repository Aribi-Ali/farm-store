<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\StorageService;
use Carbon\Carbon;
use Database\Seeders\ProductSeeder;
use Eureka\EurekaClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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




        // $client = new EurekaClient([
        //     'eurekaDefaultUrl' => "http://127.0.0.1:8761",
        //     "instanceId" => "farm1",
        //     'hostName' => "farm",
        //     'appName' => "farm",
        //     'ip' => "127.0.0.1",
        //     'port' => [8000, true],
        //     // 'EUREKA_URL' => config('services.eureka.home_page'),
        //     // 'statusPageUrl' => config('services.eureka.status_page'),
        //     // 'healthCheckUrl' => config('services.eureka.health_check'),
        // ]);
        // $client->start();


        // register_shutdown_function(function () {
        //     // Code to execute when the server is shutting down
        //     Log::info('Server is shutting down' . Carbon::now());
        // });
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
