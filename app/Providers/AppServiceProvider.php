<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\FileHelper;

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
        // Make FileHelper available in views
        Blade::directive('maxUploadSize', function () {
            return "<?php echo App\Helpers\FileHelper::getMaxUploadSizeFormatted(); ?>";
        });
    }
}
