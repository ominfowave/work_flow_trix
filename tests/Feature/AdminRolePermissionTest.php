<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminRolePermissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_guarded_user_can_resolve_role_and_permission(): void
    {
        $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'super@example.com',
            'password' => Hash::make('password123'),
        ]);

        $role = Role::create([
            'name' => 'super-admin',
            'guard_name' => 'admin',
        ]);

        $admin->assignRole($role);

        $permission = \Spatie\Permission\Models\Permission::create([
            'name' => 'manage-users',
            'guard_name' => 'admin',
        ]);

        $role->givePermissionTo($permission);

        $this->assertTrue($admin->fresh()->hasRole('super-admin'));
        $this->assertTrue($admin->fresh()->can('manage-users'));

        $this->actingAs($admin, 'admin');

        $this->assertTrue(auth('admin')->user()->hasRole('super-admin'));
        $this->assertTrue(auth('admin')->user()->can('manage-users'));
    }
}
