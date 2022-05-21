<?php

namespace Faraimunashe\Csv;

use Illuminate\Support\ServiceProvider;

class CsvServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->bind('checkfile', function ($app) {
            return new CheckFile();
        });

        $this->app->bind('newfile', function ($app) {
            return new NewFile();
        });
    }
}
