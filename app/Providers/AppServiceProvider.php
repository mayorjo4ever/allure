<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Drug;
use App\Models\Lense;
use App\Models\Frame;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Relation::morphMap([
            'drug' => Drug::class,
            'White' => Lense::class,
            'Photo ARC' => Lense::class,
            'Blue Cut Photo' => Lense::class,
            'frame' => Frame::class
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
