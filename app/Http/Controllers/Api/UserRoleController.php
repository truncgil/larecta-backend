<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * @group User Management
 * @subgroup User Roles
 */
class UserRoleController extends Controller
{
    /**
     * Display a listing of user roles
     *
     * @group User Management
     * @subgroup User Roles
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(User::with('roles')->get());
    }

    /**
     * Store a newly created user role
     *
     * @group User Management
     * @subgroup User Roles
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->roles()->sync($validated['roles']);

        return response()->json($user->load('roles'), 201);
    }

    /**
     * Display the specified user role
     *
     * @group User Management
     * @subgroup User Roles
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json($user->load('roles'));
    }

    /**
     * Update the specified user role
     *
     * @group User Management
     * @subgroup User Roles
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user->roles()->sync($validated['roles']);
        return response()->json($user->load('roles'));
    }

    /**
     * Remove all roles from the specified user
     *
     * @group User Management
     * @subgroup User Roles
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        return response()->json(null, 204);
    }
}