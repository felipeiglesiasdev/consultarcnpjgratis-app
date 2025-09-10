<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define o agendamento de comandos da aplicação.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // ADICIONE ESTA LINHA
        // Ela diz ao Laravel para executar o comando 'sitemap:generate'
        // todos os dias, à 1:00 da manhã.
        $schedule->command('sitemap:generate')->dailyAt('01:00');
    }

    /**
     * Registra os comandos para a aplicação.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

