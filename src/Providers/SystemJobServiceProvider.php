<?php

namespace nikitakilpa\SystemJob\Providers;

use Illuminate\Support\ServiceProvider;
use nikitakilpa\SystemJob\Console\Commands\PushCommand;
use nikitakilpa\SystemJob\Helpers\SystemJobManager;
use nikitakilpa\SystemJob\Repository\Impls\SystemJobRepository;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;
use nikitakilpa\SystemJob\Services\Impls\BatchCreateService;
use nikitakilpa\SystemJob\Services\Impls\CreateService;
use nikitakilpa\SystemJob\Services\Interfaces\BatchCreateInterface;
use nikitakilpa\SystemJob\Services\Interfaces\CreateInterface;

class SystemJobServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SystemJobRepositoryInterface::class, SystemJobRepository::class);
        $this->app->bind(CreateInterface::class, CreateService::class);
        $this->app->bind(BatchCreateInterface::class, BatchCreateService::class);

        $this->app->singleton('system_job', SystemJobManager::class);
    }

    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                PushCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__.'/../Config/schedule.php' => config_path('schedule.php'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../Routes/routes.php');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
