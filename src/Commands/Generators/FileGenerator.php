<?php

namespace Jenky\LaravelGenerators\Commands\Generators;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class FileGenerator extends Command
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
     * Class constructor.
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
     * Get the desired name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return $this->argument('name');
    }

    /**
     * Build the directory if necessary.
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
}
