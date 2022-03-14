<?php

namespace nikitakilpa\SystemJob\Providers;

use Illuminate\Support\ServiceProvider;
use nikitakilpa\SystemJob\Components\Impls\ManagerComponent;
use nikitakilpa\SystemJob\Components\Impls\SchedulerComponent;
use nikitakilpa\SystemJob\Components\Interfaces\ManagerInterface;
use nikitakilpa\SystemJob\Components\Interfaces\SchedulerInterface;
use nikitakilpa\SystemJob\Console\Commands\PushCommand;
use nikitakilpa\SystemJob\Helpers\SystemJobManager;
use nikitakilpa\SystemJob\Repository\Impls\SystemJobRepository;
use nikitakilpa\SystemJob\Repository\Interfaces\SystemJobRepositoryInterface;
use nikitakilpa\SystemJob\Services\Impls\BatchCreateService;
use nikitakilpa\SystemJob\Services\Impls\ManageService;
use nikitakilpa\SystemJob\Services\Interfaces\BatchCreateInterface;
use nikitakilpa\SystemJob\Services\Interfaces\ManageInterface;

class SystemJobServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SystemJobRepositoryInterface::class, SystemJobRepository::class);
        $this->app->bind(SchedulerInterface::class, SchedulerComponent::class);
        $this->app->bind(ManagerInterface::class, ManagerComponent::class);

        $this->app->bind(BatchCreateInterface::class, BatchCreateService::class);
        $this->app->bind(ManageInterface::class, ManageService::class);

        $this->app->bind(
            'create_service_mysql',
            \nikitakilpa\SystemJob\Drivers\Mysql\Services\Impls\CreateService::class
        );

        $this->app->bind(
            'create_service_mongodb',
            \nikitakilpa\SystemJob\Drivers\Mongodb\Services\Impls\CreateService::class
        );

        $this->app->singleton('system_job_scheduler', SystemJobManager::class);
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
