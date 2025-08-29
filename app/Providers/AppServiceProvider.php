<?php

namespace App\Providers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

use Filament\Http\Responses\Auth\Contracts\LogoutResponse as ContractsLogoutResponse;
use App\Http\Responses\LogoutResponse as CustomeLogoutResponse;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(ContractsLogoutResponse::class, CustomeLogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        // Model::unguard();
      //    Css::make('custom-stylesheet', 'resources/css/app.css')
    //     FilamentAsset::register([
    // //   __DIR__ . '/../../resources/css/app.css'
    //         Css::make('custom-stylesheet', Vite::asset('resources/css/app.css') ),
    //     ]);
    }
}
