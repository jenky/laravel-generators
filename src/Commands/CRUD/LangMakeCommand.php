<?php

namespace Jenky\LaravelGenerators\Commands\CRUD;

use Illuminate\Support\Str;
use Jenky\LaravelGenerators\Commands\Generators\FileGenerator;

class LangMakeCommand extends FileGenerator
{
    /**
     * {@inheritdoc}
     */
    protected $signature = 'crud:lang
        {name : The language file name}
        {--resource= : The resource name}
        {--locale= : Specify localazition}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create a new language file';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $path = $this->getPath($this->getNameInput());

        if ($this->files->exists($path)) {
            $this->error('Language already exists!');

            return false;
        }

        $this->files->put($path, $this->createFile($this->getResourceOption()));

        $this->info('Language created successfully.');
    }

    /**
     * Get the destination path.
     *
     * @param string $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel->basePath().'/resources/lang/'.$this->getLocaleOption().'/'.$name.'.php';
    }

    /**
     * Generate content for language file.
     *
     * @param string $resource
     *
     * @return string
     */
    protected function createFile($resource)
    {
        $stub = $this->files->get($this->stubPath('crud/lang.stub'));
        $resources = Str::plural($resource);

        $stub = str_replace(
            'DummyResourceNamePlural', $resources, $stub
        );

        $stub = str_replace(
            'DummyResourceName', $resource, $stub
        );

        $stub = str_replace(
            'DummyResourceStudlyPlural', Str::studly($resources), $stub
        );

        $stub = str_replace(
            'DummyResourceStudly', Str::studly($resource), $stub
        );

        return $stub;
    }

    /**
     * Get localization.
     *
     * @return string
     */
    protected function getLocaleOption()
    {
        return $this->option('locale') ?: $this->config['app.locale'];
    }

    /**
     * Get resource.
     *
     * @return string
     */
    protected function getResourceOption()
    {
        $name = $this->getNameInput();
        $resource = $this->option('resource') ?: $name;

        if (Str::contains($resource, '/')) {
            $segments = explode('/', $resource);

            $resource = is_array($segments) ? end($segments) : $resource;
        }

        return Str::singular($resource);
    }
}
