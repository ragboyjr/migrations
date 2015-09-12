<?php

namespace LaravelDoctrine\Migrations;

use Illuminate\Support\ServiceProvider;
use LaravelDoctrine\Migrations\Configuration\ConfigurationProvider;
use LaravelDoctrine\Migrations\Console\GenerateCommand;

class MigrationsServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Boot the service provider.
     * @return void
     */
    public function boot()
    {
        if (!$this->isLumen()) {
            $this->publishes([
                $this->getConfigPath() => config_path('migrations.php'),
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        $this->commands([
            GenerateCommand::class
        ]);
    }

    /**
     * Merge config
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom(
            $this->getConfigPath(), 'migrations'
        );
    }

    /**
     * @return string
     */
    protected function getConfigPath()
    {
        return __DIR__ . '/../config/migrations.php';
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            ConfigurationProvider::class
        ];
    }

    /**
     * @return bool
     */
    protected function isLumen()
    {
        return !function_exists('config_path');
    }
}