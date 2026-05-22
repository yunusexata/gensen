<?php

namespace App\Providers;

use App\Models\GensenForm\GensenForm;
use App\Observers\GensenFormObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('ai', function () {
            return new \App\AiServices\Manager\AiManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            database_path('migrations'), // Default
            database_path('migrations/user'),
            database_path('migrations/other'),
            database_path('migrations/gensen-form/*'),
            database_path('migrations/buku-nenkin'),
            database_path('migrations/ai'),
        ]);

        Blade::directive('currency', function ($expression) {
            // return "<?php echo ($expression);";
            return "<?php echo App\Helpers\NumberFormatter::format($expression); ?>";
        });
        Blade::directive('fromReiwaToYear', function ($expression) {
            // return "<?php echo ($expression);";
            return "<?php echo App\Helpers\GlobalHelper::fromReiwaToYear($expression); ?>";
        });
        GensenForm::observe(GensenFormObserver::class);
    }
}
