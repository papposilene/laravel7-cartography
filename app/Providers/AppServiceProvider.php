<?php

namespace App\Providers;

use App\Category;
use App\Country;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $menuCategories = Category::orderBy('name', 'asc')->get();
        $menuContinents = Country::selectRaw('count(*) AS continents, region')->orderBy('continents', 'desc')->groupBy('region')->get();
        view::share('menuCategories', $menuCategories);
        view::share('menuContinents', $menuContinents);

        Blade::directive('date', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y'); ?>";
        });
        Blade::directive('datedit', function ($expression) {
            return "<?php echo ($expression)->format('Y-m-d'); ?>";
        });
        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y @ H:i'); ?>";
        });
        Blade::directive('lcfirst', function ($expression) {
            return "<?php echo lcfirst($expression); ?>";
        });
        Blade::directive('ucfirst', function ($expression) {
            return "<?php echo ucfirst($expression); ?>";
        });
        Blade::directive('lowercase', function ($expression) {
            return "<?php echo strtolower($expression); ?>";
        });
        Blade::directive('nl2br', function ($expression) {
            return sprintf('<?php echo nl2br(e(%s)); ?>', $expression);
        });
        Blade::directive('uppercase', function ($expression) {
            return "<?php echo strtoupper($expression); ?>";
        });
        Blade::directive('slug', function ($expression) {
            return "<?php echo str_replace('_', ' ', $expression); ?>";
        });
        Blade::directive('time', function ($expression) {
            return "<?php echo ($expression)->format('H:i:s'); ?>";
        });
        Blade::directive('year', function ($expression) {
            return "<?php echo ($expression)->format('Y'); ?>";
        });
    }
}
