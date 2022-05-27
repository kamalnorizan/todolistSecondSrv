<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class LogCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createlog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To create laravel log';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        sleep(25);
        return Log::info('This is laravel log by command');
    }
}
