<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $adminEmail = env('ADMIN_EMAIL') ?? 'admin@truncgil.com';
        // Önce mevcut kayıtları temizle
        User::where('role', 'super-admin')->delete();

        // Super Admin rolünü Spatie ile oluştur
        $adminRole = Role::firstOrCreate(['name' => 'super-admin']);

        // Temel yetkileri Spatie formatında oluştur
        $modules = ['users', 'roles', 'permissions', 'settings'];
        $actions = ['list', 'create', 'edit', 'delete'];
        
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $action . ' ' . $module
                ]);
            }
        }

        // Tüm yetkileri admin rolüne ata
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);

        // Admin kullanıcısını oluştur
        $password = \Illuminate\Support\Str::random(12);
        $admin = User::create([
            'email' => $adminEmail,
            'name' => 'Admin',
            'role' => 'super-admin',
            'password' => Hash::make($password),
            'email_verified_at' => now()
        ]);

        // Admin rolünü Spatie yöntemiyle ata
        $admin->assignRole($adminRole);

        // Admin kullanıcısı oluşturuldu, bilgileri loglanabilir
        $this->command->info('Super Admin user created:');
        $this->command->table(['Email', 'Password'], [[
            $adminEmail,
            $password
        ]]);
    }
}
