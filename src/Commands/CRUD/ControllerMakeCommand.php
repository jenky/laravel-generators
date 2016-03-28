<?php

namespace Jenky\LaravelGenerators\Commands\CRUD;

use Illuminate\Support\Str;
use Jenky\LaravelGenerators\Commands\Generators\ResourceGenerator;

class ControllerMakeCommand extends ResourceGenerator
{
    /**
     * {@inheritdoc}
     */
    protected $signature = 'crud:controller {name : The name of the class} {resource : The name of the resource}
        {--model= : Specify model}
        {--route= : Specify route}
        {--view= : Specify view path}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new CRUD controller class';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Controller';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        return $this->stubPath('CRUD/controller.stub');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    /**
     * Get the resource name.
     *
     * @return string
     */
    protected function getResourceName()
    {
        return strtolower(Str::singular($this->argument('resource')));
    }

    /**
     * Get route name.
     *
     * @return string
     */
    protected function getRouteName()
    {
        return $this->option('route') ?: Str::plural($this->getResourceName());
    }

    /**
     * Get view path.
     *
     * @return string
     */
    protected function getViewPath()
    {
        return $this->option('view') ?: Str::plural($this->getResourceName());
    }

    /**
     * {@inheritdoc}
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $parent = parent::replaceNamespace($stub, $name);

        $stub = str_replace(
            'DummyRouteName', $this->getRouteName(), $stub
        );

        $stub = str_replace(
            'DummyViewPath', $this->getViewPath(), $stub
        );

        return $parent;
    }
}
