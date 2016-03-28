<?php

namespace Jenky\LaravelGenerators\Commands\CRUD;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ViewMakeCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new controller creator command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files, Config $config)
    {
        parent::__construct();

        $this->files = $files;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    protected $signature = 'crud:view
        {name : The resource name}
        {path : The view path}
        {--route= : Specify route}
        {--f|force : Force replace file}';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Create CRUD views';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire()
    {
        $path = $this->getPath($this->getPathInput());

        if ($this->option('force')) {
            $this->files->deleteDirectory($path, 0777, true, true);
        } else {
            if ($this->files->exists($path)) {
                $this->error('Views already exists!');

                return false;
            }
        }

        $this->makeDirectory($path);

        $this->generateViews('index', 'edit');

        $this->info('Views created successfully.');
    }

    /**
     * Get the desired resource name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->argument('name');
    }

    /**
     * Get the desired path from the input.
     *
     * @return string
     */
    protected function getPathInput()
    {
        return $this->argument('path');
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
        return $this->laravel->basePath().'/resources/views/'.$name;
    }

    /**
     * Get stub path for give view.
     *
     * @param string $view
     *
     * @return string
     */
    protected function getStubPath($view)
    {
        return $this->config['crud-generator.view_path']
            ? Str::finish($this->config['crud-generator.view_path'], '/').$view
            : Str::finish(__DIR__.'/../../../stubs/CRUD/views', '/').$view;
    }

    /**
     * Build the directory for the view if necessary.
     *
     * @param string $path
     *
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
    }

    /**
     * Generate views.
     *
     * @param mixed $views
     *
     * @return void
     */
    protected function generateViews($views)
    {
        $views = is_array($views) ? $views : func_get_args();

        foreach ($views as $view) {
            $this->generateView($view);
        }
    }

    /**
     * Generate view with give resource name.
     *
     * @param string $view
     *
     * @return void
     */
    protected function generateView($view)
    {
        $path = $this->getPath($this->getPathInput());
        $stub = $this->files->get($this->getStubPath($view.'.stub'));
        $this->replaceResourceName($stub, $this->getNameInput());

        $this->files->put(Str::finish($path, '/').$view.'.blade.php', $stub);
    }

    /**
     * Replace the resource name for the given stub.
     *
     * @param string $stub
     * @param string $name
     *
     * @return $this
     */
    protected function replaceResourceName(&$stub, $name)
    {
        $stub = str_replace(
            'DummyResourceNamePlural', Str::plural($name), $stub
        );

        $stub = str_replace(
            'DummyResourceName', $name, $stub
        );

        $routeName = $this->option('route')
            ? Str::plural($this->option('route'))
            : $name;

        $stub = str_replace(
            'DummyRouteName', $routeName, $stub
        );

        return $this;
    }
}
