<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
    	echo date("Y-m-d H:i:s") . PHP_EOL;
    	$schedule->command('summary:run')->cron('*/5 9-16 * * *');
	    $schedule->command('summary:day')->cron('15 0 * * 1-5');
	    $schedule->command('summary:week')->cron('0 8 * * 1');
        $schedule->command('summary:month')->cron('0 8 1 * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
