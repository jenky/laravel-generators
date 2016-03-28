<?php

namespace Jenky\LaravelGenerators\Commands;

use Jenky\LaravelGenerators\Commands\Generators\ModelGenerator;

class TransformerMakeCommand extends ModelGenerator
{
    /**
     * {@inheritdoc}
     */
    protected $signature = 'make:transformer {name : The name of the class}
        {--model= : Specify model}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new fractal transformer class (require league/fractal)';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Transformer';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        if ($this->option('model')) {
            return $this->stubPath('transformer.model.stub');
        }

        return $this->stubPath('transformer.stub');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Transformers';
    }
}
