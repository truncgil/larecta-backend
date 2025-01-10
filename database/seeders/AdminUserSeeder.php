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
        // Önce mevcut kayıtları temizle
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        Permission::truncate();
        DB::table('role_permissions')->truncate();
        DB::table('user_roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Super Admin rolünü oluştur
        $adminRole = Role::create([
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'description' => 'Tüm yetkilere sahip yönetici rolü'
        ]);

        // Temel yetkileri oluştur
        $modules = ['users', 'roles', 'permissions', 'settings'];
        
        foreach ($modules as $module) {
            Permission::create([
                'name' => ucfirst($module) . ' Yönetimi',
                'slug' => $module . '-management',
                'module' => $module,
                'actions' => ['read', 'write', 'update', 'delete']
            ]);
        }

        // Tüm yetkileri admin rolüne ata
        $permissions = Permission::all();
        $adminRole->permissions()->sync($permissions->pluck('id')->toArray());

        // Admin kullanıcısını oluştur veya güncelle
        $password = \Illuminate\Support\Str::random(12);
        $admin = User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
                'role' => 'super-admin',
                'email_verified_at' => now()
            ]
        );
        // Admin kullanıcısı oluşturuldu, bilgileri loglanabilir
        $this->command->info('Admin kullanıcısı oluşturuldu:');
        $this->command->table(['Email', 'Password'], [[
            $admin->email,
            $password
        ]]);

        // Admin rolünü kullanıcıya ata
        $admin->roles()->sync([$adminRole->id]);
    }
}
