<?php
/**
 * This file is part of laravel-stubs package.
 *
 * @author ATehnix <atehnix@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ATehnix\LaravelStubs\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class StubsPublishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stubs:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish any stub files from framework';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Path to the Laravel Framework source directory
     *
     * @var string
     */
    protected $frameworkPath = 'vendor/laravel/framework/src/';

    /**
     * Paths to stub files
     *
     * @var array
     */
    protected $stubs = [
        'Illuminate/Database/Console/Seeds/stubs/seeder.stub',
        'Illuminate/Foundation/Console/stubs/console.stub',
        'Illuminate/Foundation/Console/stubs/event.stub',
        'Illuminate/Foundation/Console/stubs/job.stub',
        'Illuminate/Foundation/Console/stubs/job-queued.stub',
        'Illuminate/Foundation/Console/stubs/listener.stub',
        'Illuminate/Foundation/Console/stubs/listener-queued.stub',
        'Illuminate/Foundation/Console/stubs/mail.stub',
        'Illuminate/Foundation/Console/stubs/model.stub',
        'Illuminate/Foundation/Console/stubs/notification.stub',
        'Illuminate/Foundation/Console/stubs/policy.plain.stub',
        'Illuminate/Foundation/Console/stubs/policy.stub',
        'Illuminate/Foundation/Console/stubs/provider.stub',
        'Illuminate/Foundation/Console/stubs/request.stub',
        'Illuminate/Foundation/Console/stubs/test.stub',
        'Illuminate/Routing/Console/stubs/controller.plain.stub',
        'Illuminate/Routing/Console/stubs/controller.stub',
        'Illuminate/Routing/Console/stubs/middleware.stub',
    ];

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = config('stubs.path');
        $this->createDirectory($path);

        foreach ($this->stubs as $stub) {
            $from = base_path($this->frameworkPath. $stub);
            $to = $path . '/'. basename($stub);
            $this->publishFile($from, $to);
        }
    }

    /**
     * Publish the file to the given path.
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    protected function publishFile($from, $to)
    {
        if ($this->files->exists($to)) {
            return;
        }

        $this->files->copy($from, $to);
        $this->info('Stub published: ' . basename($to));
    }

    /**
     * Create the directory to house the published files if needed.
     *
     * @param  string  $directory
     * @return void
     */
    protected function createDirectory($directory)
    {
        if (! $this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }
}
