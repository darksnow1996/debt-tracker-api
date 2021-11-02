<?php

namespace App\Console;

use App\Jobs\UpdateCoaches;
use App\Jobs\UpdateContinents;
use App\Jobs\UpdateCountries;
use App\Jobs\UpdateFixtures;
use App\Jobs\UpdateLastFixtures;
use App\Jobs\UpdateLeagues;
use App\Jobs\UpdateRounds;
use App\Jobs\UpdateSeasons;
use App\Jobs\UpdateStages;
use App\Jobs\UpdateTeams;
use App\Jobs\UpdateVenues;
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
        $schedule->command('inspire')->hourly();
    
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
