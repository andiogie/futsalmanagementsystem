<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role; // <-- ini penting

class RolesSeeder extends Command
{
    protected $signature = 'app:roles-seeder';
    protected $description = 'Generate default roles (admin, member, owner)';

    public function handle()
    {
        $roles = ['admin', 'member', 'owner'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role], ['guard_name' => 'web']);
            $this->info("Role '{$role}' berhasil dibuat atau sudah ada.");
        }

        $this->info('Selesai membuat role!');
    }
}
