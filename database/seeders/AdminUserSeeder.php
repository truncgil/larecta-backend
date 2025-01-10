<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $adminEmail = env('ADMIN_EMAIL') ?? 'admin@truncgil.com';
        // Önce mevcut kayıtları temizle
        User::where('role', 'super-admin')->delete();

        // Super Admin rolünü oluştur veya güncelle
        $adminRole = Role::updateOrCreate(
            ['slug' => 'super-admin'],
            [
                'name' => 'Super Admin', 
                'description' => 'Tüm yetkilere sahip yönetici rolü'
            ]
        );

        // Temel yetkileri oluştur
        $modules = ['users', 'roles', 'permissions', 'settings'];
        
        foreach ($modules as $module) {
            Permission::updateOrCreate(
                ['slug' => $module . '-management'],
                [
                    'name' => ucfirst($module) . ' Yönetimi',
                    'module' => $module,
                    'actions' => ['read', 'write', 'update', 'delete']
                ]
            );
        }

        // Tüm yetkileri admin rolüne ata
        $permissions = Permission::all();
        $adminRole->permissions()->sync($permissions->pluck('id')->toArray());

        // Admin kullanıcısını oluştur veya güncelle
        $password = \Illuminate\Support\Str::random(12);
        $admin = User::create(
            [
                'email' => $adminEmail,
                'name' => 'Admin',
                'password' => Hash::make($password),
                'role' => 'super-admin',
                'email_verified_at' => now()
            ]
        );
        // Admin kullanıcısı oluşturuldu, bilgileri loglanabilir
        $this->command->info('Admin kullanıcısı oluşturuldu:');
        $this->command->table(['Email', 'Password'], [[
            $adminEmail,
            $password
        ]]);

        // Admin rolünü kullanıcıya ata
        $admin->roles()->sync([$adminRole->id]);
    }
}
