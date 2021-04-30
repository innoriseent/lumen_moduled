<?php

namespace App\Console;

use App\Console\Commands\Module\ModuleImport;
use App\Console\Commands\Module\ModuleList;
use Codeex\RoleAssignment\Console\Commands\PingRolesAssignment;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ModuleList::class,
        ModuleImport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
