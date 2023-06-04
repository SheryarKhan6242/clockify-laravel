<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Report;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $reports = Report::whereDate('login_date', Carbon::today()->format('Y-m-d'))
                ->whereNull('office_out')
                ->get();
    
            foreach ($reports as $report) {
                $officeIn = Carbon::parse($report->office_in);
                $report->office_out = Carbon::now()->format('H:i:s');
                $report->total_work_hours = gmdate('H:i:s',$officeIn->diffInSeconds($report->office_out));
                $report->save();
            }
        })->dailyAt('11:59');
        
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
