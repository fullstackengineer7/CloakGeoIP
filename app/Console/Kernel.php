<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\Game1Controller;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    
    protected function schedule(Schedule $schedule)
    {
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

        // $schedule->call(function () {
        //     dd("starting bid calculation"); //????? socket die?
        //     $game1 = new Game1Controller();
        //     $game1->calculateBid();
        // })->everyFiveMinutes();