<?php

namespace App\Providers;

use App\Models\GensenForm\GensenForm;
use App\Models\GensenForm\GensenFormAttachment;
use App\Observers\GensenAttachmentObserver;
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
            database_path('migrations/ichijikin-extraction'),
            database_path('migrations/resi-generator'),
            database_path('migrations/list-posting'),
        ]);

        Blade::directive('currency', function ($expression) {
            // return "<?php echo ($expression);";
            return "<?php echo App\Helpers\NumberFormatter::format($expression); ?>";
        });
        Blade::directive('fromReiwaToYear', function ($expression) {
            // return "<?php echo ($expression);";
            return "<?php echo fromReiwaToYear($expression); ?>";
        });
        GensenForm::observe(GensenFormObserver::class);
        GensenFormAttachment::observe(GensenAttachmentObserver::class);
    }
}
