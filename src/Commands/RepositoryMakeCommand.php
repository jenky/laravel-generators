<?php

namespace Jenky\LaravelGenerators\Commands;

use Jenky\LaravelGenerators\Commands\Generators\ModelGenerator;

class RepositoryMakeCommand extends ModelGenerator
{
    /**
     * {@inheritdoc}
     */
    protected $signature = 'make:repo {name : The name of the class}
        {--model= : Specify model}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new repository class';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Repository';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        if ($this->option('model')) {
            return $this->stubPath('repository.model.stub');
        }

        return $this->stubPath('repository.stub');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }
}
