<?php

namespace Araiyusuke\FakeApi;

use Illuminate\Support\ServiceProvider;
use Araiyusuke\FakeApi\FakeApiCommand;

class FakeApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

     /**
     * Boot the custom commands
     *
     * @return void
     */
    private function bootCommands()
    {

        $this->publishes([
            __DIR__.'/api-config.yml' => storage_path('app/api-config.yml'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                FakeApiCommand::class
            ]);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootCommands();
    }
}