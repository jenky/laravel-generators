<?php

namespace Jenky\LaravelGenerators\Commands;

use Jenky\LaravelGenerators\Commands\Generators\GeneratorCommand;

class ContractMakeCommand extends GeneratorCommand
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'make:contract';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new contract class';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Contract';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        return $this->stubPath('contract.stub');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Contracts';
    }
}
