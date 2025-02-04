<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Super Admin rolünü oluştur
        $superAdmin = Role::create(['name' => 'super-admin']);
        
        // Gerekli izinleri oluştur ve ata
        // ... izinler ...
    }
} 