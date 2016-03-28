<?php

namespace Jenky\LaravelGenerators\Commands\API;

use Jenky\LaravelGenerators\Commands\Generators\ResourceGenerator;
use Symfony\Component\Console\Input\InputOption;

class RequestMakeCommand extends ResourceGenerator
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'api:request';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new API request class';

    /**
     * {@inheritdoc}
     */
    protected $type = 'Request';

    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
        if ($this->option('resource')) {
            return $this->stubPath('API/request.resource.stub');
        }

        return $this->stubPath('API/request.stub');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests';
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        $options = parent::getOptions();

        $options[] = ['guard', 'g', InputOption::VALUE_OPTIONAL, 'Generate request class that authorized by guard driver.'];

        return $options;
    }
}
