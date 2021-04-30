<?php

namespace App\Console\Commands\Module;

use App\Lib\ModuleInjector;
use Illuminate\Console\Command;

class ModuleList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of added packages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var ModuleInjector $injector */
        $injector = app()->injector;
        print_r($injector->getModules());
    }
}
