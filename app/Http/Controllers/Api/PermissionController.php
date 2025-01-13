<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * @group Permission Management
 * @subgroup Permission Controller
 * This controller handles the CRUD operations for the Permission model.
 */
class PermissionController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @group Permission Management
     * @subgroup Listing Operations
     * Display a listing of all permissions.
     */
    public function index()
    {
        return response()->json(Permission::all(), 200);
    }

    /**
     * @group Permission Management
     * @subgroup Create Operations
     * Create a new permission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions',
            'description' => 'nullable|string'
        ]);

        $permission = Permission::create($validated);
        return response()->json($permission, 201);
    }

    /**
     * @group Permission Management
     * @subgroup View Operations
     * Display the specified permission.
     */
    public function show(Permission $permission)
    {
        return response()->json($permission, 200);
    }

    /**
     * @group Permission Management
     * @subgroup Update Operations
     * Update the specified permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string'
        ]);

        $permission->update($validated);
        return response()->json($permission, 200);
    }

    /**
     * @group Permission Management
     * @subgroup Delete Operations
     * Remove the specified permission.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }
} 