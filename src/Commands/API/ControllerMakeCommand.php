<?php

namespace Jenky\LaravelGenerators\Commands\API;

use Jenky\LaravelGenerators\Commands\Generators\ResourceGenerator;

class ControllerMakeCommand extends ResourceGenerator
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'api:controller';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new API controller class';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Controller';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        if ($this->option('resource')) {
            return $this->stubPath('API/controller.resource.stub');
        }

        return $this->stubPath('API/controller.stub');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }
}
