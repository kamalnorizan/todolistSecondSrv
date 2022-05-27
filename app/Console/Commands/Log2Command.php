<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
class Log2Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createsecondlog';

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
        return Log::info('This is laravel second log by command');
    }
}
