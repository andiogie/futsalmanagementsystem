<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UseProductionEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:use-production-env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch ke .env.production';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        copy(base_path('.env.production'), base_path('.env'));
        $this->call('config:clear');
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->info('✅ Environment switched to PRODUCTION');
    }
}
