<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Pemesanan;
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
        // $schedule->command('inspire')->hourly();
            $schedule->call(function () {
            
                $data = Pemesanan::where('status', 'Menunggu')->latest()->get();

                foreach($data as $d){
                    $created =  Carbon::parse($d->created_at)->addHour(3);
                    $now = Carbon::now();
                    if($tmpo < $now){
                        $d->status_penyewaan = 'Ditolak';
                        $d->save();
                    }
                }
            //Pengecekan apakah cronjob berhasil atau tidak
        //Mencatat info log 
                // Log::info('Cronjob berhasil dijalankan');
                // if


            })->everyTwoMinutes();
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
