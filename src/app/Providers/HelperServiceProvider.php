<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\PermissionHelper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register helper functions globally
        $helperPath = app_path('Helpers/helper_functions.php');
        if (file_exists($helperPath)) {
            require_once $helperPath;
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
