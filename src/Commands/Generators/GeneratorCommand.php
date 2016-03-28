<?php

namespace Jenky\LaravelGenerators\Commands\Generators;

use Illuminate\Console\GeneratorCommand as Generator;
use Illuminate\Support\Str;

class GeneratorCommand extends Generator
{
    /**
     * {@inheritdoc}
     */
    protected function getStub()
    {
    }

    /**
     * Get the stub path.
     *
     * @param string $path
     *
     * @return string
     */
    protected function stubPath($path)
    {
        return Str::finish(__DIR__.'/../../../stubs', '/').$path;
    }

    /**
     * Try to get the class name.
     *
     * @return string
     */
    protected function guessClassName($option)
    {
        $rootNamespace = $this->laravel->getNamespace();
        $name = $this->option($option);

        $classNameWithDirectory = $this->parseClassName(ucfirst($name));
        $className = $rootNamespace.ucfirst($name);

        return class_exists($classNameWithDirectory) ? $classNameWithDirectory : $className;
    }

    /**
     * Parse class name.
     *
     * @param string $name
     *
     * @return string
     */
    protected function parseClassName($name)
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
     * Get the class name from namespace path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getClassName($name)
    {
        $segments = explode('\\', $name);

        return is_array($segments) ? end($segments) : $name;
    }
}
