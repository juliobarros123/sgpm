<?php

namespace App\Providers;

use App\Models\TipoServico;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {
            
            // $dados['site_tipo_servicos'] = TipoServico::get();

            //dd($dados['site_tipo_servicos']);
            // if (isset($dados)) {
            //     $view->with('site_tipo_servicos', $dados['site_tipo_servicos']);
            // }
        });
    }
}
