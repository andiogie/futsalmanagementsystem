<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UseLocalEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:use-local-env';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch ke .env.local';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        copy(base_path('.env.local'), base_path('.env'));
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->info('✅ Environment switched to LOCAL');
    }
}
