<?php

namespace App\Console;

use App\SubscriptionsUsage;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        /**
         * Reset every subscription usage to 0 the first day of the month
         */
        $schedule->call(function(){

            $usages = SubscriptionsUsage::all();

            foreach ($usages as $usage) {
                $quotas_to_update = json_decode($usage->quotas);
                $quotas_to_update->search->used   = 0;
                $quotas_to_update->contacts->used = 0;

                $quotas_to_update = json_encode($quotas_to_update);
                SubscriptionsUsage::where('id', $usage->id)->update(['quotas' => $quotas_to_update]);
            }

        })->monthlyOn(1, '01:00');

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
