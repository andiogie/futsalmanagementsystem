<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RenameViewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rename:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rename folder and references: mobile -> member, dashboard -> admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("🔄 Mulai proses rename...");

        // 1. Ganti folder resources/views/mobile -> member
        if (File::isDirectory(resource_path('views/mobile'))) {
            File::move(resource_path('views/mobile'), resource_path('views/member'));
            $this->info("✅ Folder 'mobile' diganti jadi 'member'");
        }

        // 2. Ganti folder resources/views/dashboard -> admin
        if (File::isDirectory(resource_path('views/dashboard'))) {
            File::move(resource_path('views/dashboard'), resource_path('views/admin'));
            $this->info("✅ Folder 'dashboard' diganti jadi 'admin'");
        }

        // 3. Ganti semua referensi di file project
        $paths = [
            base_path('routes'),
            app_path('Http/Controllers'),
            resource_path('views'),
        ];

        foreach ($paths as $path) {
            $this->replaceInFiles($path, 'mobile', 'member');
            $this->replaceInFiles($path, 'dashboard', 'admin');
        }

        $this->info("🎉 Semua selesai diganti!");
    }

    private function replaceInFiles($path, $search, $replace)
    {
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $contents = File::get($file->getPathname());

            if (strpos($contents, $search) !== false) {
                $newContents = str_replace($search, $replace, $contents);
                File::put($file->getPathname(), $newContents);
                $this->line("   ↪ {$file->getFilename()} : {$search} → {$replace}");
            }
        }
    }
}
