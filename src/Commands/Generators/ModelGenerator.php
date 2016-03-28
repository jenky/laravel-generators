<?php

namespace Jenky\LaravelGenerators\Commands\Generators;

class ModelGenerator extends GeneratorCommand
{
    /**
     * {@inheritdoc}
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $parent = parent::replaceNamespace($stub, $name);

        $model = str_replace('/', '\\', $this->guessClassName('model'));
        $modelName = $this->getClassName($model);

        $stub = str_replace(
            'DummyModelClass', $model, $stub
        );

        $stub = str_replace(
            'DummyModelName', $modelName, $stub
        );

        $stub = str_replace(
            'DummyResourceName', strtolower($modelName), $stub
        );

        return $parent;
    }
}
