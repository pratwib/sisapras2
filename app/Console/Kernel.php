<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // get all the borrow that have not been returned and have exceeded due date
            $overdueBorrow = DB::table('borrows')
                ->where('lend_status', '=', 'borrowed')
                ->where('return_date', '<', Carbon::now())
                ->get();

            foreach ($overdueBorrow as $borrow) {
                // Ubah status menjadi "overdue"
                DB::table('borrows')
                    ->where('borrows.borrow_id', $borrow->borrow_id)
                    ->update(['lend_status' => 'overdue']);
            }
        })->dailyAt('00:00'); // Jalankan setiap hari pukul 00:00
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
