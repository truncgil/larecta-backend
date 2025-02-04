<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

/**
 * @group Role Management
 * @subgroup Role Controller
 * This controller handles the CRUD operations for the Role model.
 */
class RoleController extends Controller
{
    /**
     * @group Role Management
     * @subgroup Listing Operations
     * Display a listing of all roles with their associated permissions.
     */
    public function index()
    {
        return response()->json(Role::with('permissions')->get());
    }

    /**
     * @group Role Management  
     * @subgroup Create Operations
     * Create a new role with optional permissions.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role = Role::create($validated);
        
        if (isset($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return response()->json($role->load('permissions'));
    }

    /**
     * @group Role Management
     * @subgroup View Operations  
     * Display the specified role with its permissions.
     */
    public function show(Role $role)
    {
        return response()->json($role->load('permissions'));
    }

    /**
     * @group Role Management
     * @subgroup Update Operations
     * Update the specified role and its permissions.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $role->update($validated);
        
        if (isset($validated['permissions'])) {
            $role->permissions()->sync($validated['permissions']);
        }

        return response()->json($role->load('permissions'));
    }

    /**
     * @group Role Management
     * @subgroup Delete Operations
     * Remove the specified role and detach all its permissions.
     */
    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();
        return response()->json(null);
    }
} 