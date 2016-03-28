<?php

namespace Jenky\LaravelGenerators\Commands\Generators;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ResourceGenerator extends GeneratorCommand
{
    /**
     * Get the resource name.
     *
     * @return string
     */
    protected function getResourceName()
    {
        return strtolower(Str::singular($this->option('resource')));
    }

    /**
     * Get the model name.
     *
     * @return string
     */
    protected function getModelName()
    {
        return $this->option('model') ?: $this->getResourceName();
    }

    /**
     * Try to get the model name.
     *
     * @return string
     */
    protected function guessModelName()
    {
        $rootNamespace = $this->laravel->getNamespace();
        $name = $this->getModelName();

        $modelNameWithDirectory = $this->parseModelName(ucfirst($name));
        $modelName = $rootNamespace.ucfirst($name);

        return class_exists($modelNameWithDirectory) ? $modelNameWithDirectory : $modelName;
    }

    /**
     * Parse model name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function parseModelName($name)
    {
        $rootNamespace = $this->laravel->getNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        if (Str::contains($name, '/')) {
            $name = str_replace('/', '\\', $name);
        }

        return trim($rootNamespace, '\\').'\\'.$name;
    }

    /**
     * {@inheritdoc}
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $parent = parent::replaceNamespace($stub, $name);

        $stub = str_replace(
            'DummyModelClass', str_replace('/', '\\', $this->guessModelName()), $stub
        );

        $resourceName = $this->getResourceName();

        $stub = str_replace(
            'DummyResourceClass', ucfirst($resourceName), $stub
        );

        $stub = str_replace(
            'DummyResourceNamePlural', Str::plural($resourceName), $stub
        );

        $stub = str_replace(
            'DummyResourceName', $resourceName, $stub
        );

        // $authorize = is_null($this->option('guard'))
        //     ? "auth()->check()"
        //     : "auth('{$this->option('guard')}')->check()";

        // $stub = str_replace(
        //     'AuthorizeRequest', $authorize, $stub
        // );

        return $parent;
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        return [
            ['resource', 'r', InputOption::VALUE_OPTIONAL, 'Generate '.strtolower($this->name).' class with a resource name.'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate '.strtolower($this->name).' class with model class.'],
        ];
    }
}
