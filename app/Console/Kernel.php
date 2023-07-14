<?php

namespace App\Console;

use App\Console\Commands\SendProductExpiredToAdmin;
use App\Console\Commands\SendProductNearlyExpiredToAdmin;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        SendProductExpiredToAdmin::class,
        SendProductNearlyExpiredToAdmin::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('activitylog:clean')->daily();
        // $schedule->command('notify:send-product-expired-to-admin')->dailyAt('7:00');
        $schedule->command('notify:send-product-expired-to-admin')->dailyAt('7:00');
        $schedule->command('notify:send-product-nearly-expired-to-admin')->dailyAt('7:00');
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
