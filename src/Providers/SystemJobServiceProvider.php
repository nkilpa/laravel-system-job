<?php

namespace nikitakilpa\SystemJob\Providers;

use Illuminate\Support\ServiceProvider;
use nikitakilpa\SystemJob\Console\Commands\PushCommand;
use nikitakilpa\SystemJob\Repository\Implements\SystemJobRepository;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;

class SystemJobServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SystemJobRepositoryInterface::class, SystemJobRepository::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                PushCommand::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
