<?php

namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller;

use App\Models\Type;
use Illuminate\Http\Request;

/**
 * This controller handles the CRUD operations for the Type model.
 * @group Type Management
 * @subgroup Type Controller
 * 
 */
class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @group Type Management
     * @subgroup Listing Operations
     */
    public function index()
    {
        $types = Type::orderBy('order', 'asc')->get();
        return response()->json($types);
    }

    /**
     * Display the specified resource.
     * 
     * @group Type Management  
     * @subgroup View Operations
     */
    public function show(Type $type)
    {
        return response()->json($type);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @group Type Management
     * @subgroup Create Operations
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:types,slug',
            'description' => 'nullable|string',
        ]);

        $type = Type::create($request->all());
        return response()->json([
            'message' => 'Type created successfully',
            'data' => $type
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     * 
     * @group Type Management
     * @subgroup Update Operations
     */
    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:types,slug',
            'description' => 'nullable|string',
            'icon' => 'sometimes|nullable|string',
            'order' => 'sometimes|integer',
            'status' => 'sometimes|in:active,inactive,pending'
        ]);

        $type->update($request->only(['name', 'description', 'icon', 'order', 'status']));
        return response()->json([
            'message' => 'Type başarıyla güncellendi',
            'data' => $type
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @group Type Management
     * @subgroup Delete Operations
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return response()->json([
            'message' => 'Type deleted successfully'
        ]);
    }
}