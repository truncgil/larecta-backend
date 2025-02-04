<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateSuperAdmin extends Command
{
    /**
     * Komutun imzası (terminalden çağırma şekli).
     *
     * @var string
     */
    protected $signature = 'create-super-admin';

    /**
     * Komut açıklaması.
     *
     * @var string
     */
    protected $description = 'Create a super admin user by seeding AdminUserSeeder';

    /**
     * Komutun mantığı.
     *
     * @return int
     */
    public function handle()
    {
        // Seeder'ı çalıştır
        $this->call('db:seed', [
            '--class' => 'AdminUserSeeder',
        ]);

        return Command::SUCCESS;
    }
}
