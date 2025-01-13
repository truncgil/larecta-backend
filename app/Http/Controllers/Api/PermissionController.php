<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

/**
 * This controller handles the CRUD operations for the Permission model.
 * @group Permission Management
 * @subgroup Permission Controller
 * 
 */
class PermissionController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the resource.
     * 
     * @group Permission Management
     * @subgroup Listing Operations
     */
    public function index()
    {
        return response()->json(Permission::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @group Permission Management
     * @subgroup Create Operations
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
     * Display the specified resource.
     * 
     * @group Permission Management
     * @subgroup View Operations
     */
    public function show(Permission $permission)
    {
        return response()->json($permission, 200);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @group Permission Management
     * @subgroup Update Operations
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
     * Remove the specified resource from storage.
     * 
     * @group Permission Management
     * @subgroup Delete Operations
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }
}