<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $role;
    protected $permission;

    protected function setUp(): void
    {
        parent::setUp();

        // Test için gerekli verileri oluştur
        $this->role = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => 'İçerik editörü'
        ]);

        $this->permission = Permission::create([
            'name' => 'Makale Yönetimi',
            'slug' => 'article-management',
            'module' => 'articles',
            'actions' => ['read', 'write', 'update', 'delete']
        ]);

        $this->user = User::factory()->create();
    }

    /** @test */
    public function role_can_be_assigned_to_user()
    {
        $this->user->assignRole($this->role);
        
        $this->assertTrue($this->user->hasRole('Editor'));
    }

    /** @test */
    public function permission_can_be_assigned_to_role()
    {
        $this->role->permissions()->attach($this->permission);
        $this->user->assignRole($this->role);

        $this->assertTrue($this->user->hasPermission('articles', 'read'));
    }

    /** @test */
    public function role_can_be_removed_from_user()
    {
        $this->user->assignRole($this->role);
        $this->user->removeRole($this->role);

        $this->assertFalse($this->user->hasRole('Editor'));
    }

    /** @test */
    public function user_can_have_multiple_roles()
    {
        $adminRole = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Yönetici'
        ]);

        $this->user->assignRole($this->role);
        $this->user->assignRole($adminRole);

        $this->assertTrue($this->user->hasRole('Editor'));
        $this->assertTrue($this->user->hasRole('Admin'));
    }

    /** @test */
    public function user_permissions_are_properly_checked()
    {
        $this->role->permissions()->attach($this->permission);
        $this->user->assignRole($this->role);

        $this->assertTrue($this->user->hasPermission('articles', 'read'));
        $this->assertTrue($this->user->hasPermission('articles', 'write'));
        $this->assertFalse($this->user->hasPermission('articles', 'invalid-action'));
    }

    /** @test */
    public function permission_check_fails_without_role()
    {
        $this->assertFalse($this->user->hasPermission('articles', 'read'));
    }
}
