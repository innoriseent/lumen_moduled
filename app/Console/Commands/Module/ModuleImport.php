<?php

namespace App\Console\Commands\Module;

use App\Services\ModulesService;
use Codeex\RoleAssignment\RoleAssignmentServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ModuleImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:import {--path=path : Path of repository to clone it}
                                          {--merging=true : With merging routes, tables, etc}
                                          {--vendor=codeex : Name of Vendor}
                                          {--module=module}
                                          ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import module and merging it with system';

    protected $moduleService = null;

    /**
     * ModuleImport constructor.
     * @param ModulesService $moduleService
     */
    public function __construct(ModulesService $moduleService)
    {
        $this->moduleService = $moduleService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $vendor = $this->option('vendor');
            $path = $this->option('path');
            $module = $this->option('module');
            if (!empty($vendor) && (!empty($module) && $module !== 'module') && !empty($path)) {
                $this->moduleService->importModule($vendor, $module, $path);
                return true;
            }
            die("Invalid arguments");
        }catch (\Throwable $t){
            Log::error($t);
        }
    }
}
