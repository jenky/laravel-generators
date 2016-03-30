<?php

namespace Jenky\LaravelGenerators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register any package services.
     */
    public function register()
    {
        $this->registerControllerGenerator();
        $this->registerRequestGenerator();
        $this->registerModelGenerator();
        $this->registerRepositoryGenerator();
        $this->registerContractGenerator();
        $this->registerTransformerGenerator();
        $this->registerViewGenerator();
        $this->registerLangGenerator();
    }

    /**
     * Register the make:api:controller & crud:controller command.
     */
    protected function registerControllerGenerator()
    {
        $this->app->singleton('command.api.controller', function ($app) {
            return $app[Commands\API\ControllerMakeCommand::class];
        });

        $this->app->singleton('command.crud.controller', function ($app) {
            return $app[Commands\CRUD\ControllerMakeCommand::class];
        });

        $this->commands('command.api.controller');
        $this->commands('command.crud.controller');
    }

    /**
     * Register the make:api:request command.
     */
    protected function registerRequestGenerator()
    {
        $this->app->singleton('command.api.request', function ($app) {
            return $app[Commands\API\RequestMakeCommand::class];
        });

        $this->commands('command.api.request');
    }

    /**
     * Register the crud:model command.
     */
    protected function registerModelGenerator()
    {
        $this->app->singleton('command.crud.model', function ($app) {
            return $app[Commands\CRUD\ModelMakeCommand::class];
        });

        $this->commands('command.crud.model');
    }

    /**
     * Register the make:repo command.
     */
    protected function registerRepositoryGenerator()
    {
        $this->app->singleton('command.make.repository', function ($app) {
            return $app[Commands\RepositoryMakeCommand::class];
        });

        $this->commands('command.make.repository');
    }

    /**
     * Register the make:contract command.
     */
    protected function registerContractGenerator()
    {
        $this->app->singleton('command.make.contract', function ($app) {
            return $app[Commands\ContractMakeCommand::class];
        });

        $this->commands('command.make.contract');
    }

    /**
     * Register the make:transformer command.
     */
    protected function registerTransformerGenerator()
    {
        $this->app->singleton('command.make.transformer', function ($app) {
            return $app[Commands\TransformerMakeCommand::class];
        });

        $this->commands('command.make.transformer');
    }

    /**
     * Register the crud:view command.
     */
    protected function registerViewGenerator()
    {
        $this->app->singleton('command.crud.view', function ($app) {
            return $app[Commands\CRUD\ViewMakeCommand::class];
        });

        $this->commands('command.crud.view');
    }

    /**
     * Register the crud:lang command.
     */
    protected function registerLangGenerator()
    {
        $this->app->singleton('command.crud.lang', function ($app) {
            return $app[Commands\CRUD\LangMakeCommand::class];
        });

        $this->commands('command.crud.lang');
    }
}
