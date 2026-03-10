<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use App\Helpers\CurrencyHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        
        // Register CurrencyHelper as a global helper
        if (!function_exists('currency')) {
            function currency($amount, $decimals = 2) {
                return CurrencyHelper::format($amount, $decimals);
            }
        }
        
        if (!function_exists('currency_number')) {
            function currency_number($amount, $decimals = 2) {
                return CurrencyHelper::formatNumber($amount, $decimals);
            }
        }
        
        if (!function_exists('currency_symbol')) {
            function currency_symbol() {
                return CurrencyHelper::symbol();
            }
        }
    }
}
