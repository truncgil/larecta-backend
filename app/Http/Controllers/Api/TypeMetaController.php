<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use App\Models\TypeMeta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * This controller handles the CRUD operations for the TypeMeta model.
 * @group Type Management
 * @subgroup TypeMeta Controller
 */
class TypeMetaController extends Controller
{
    /**
     * Get all meta fields for a type.
     * @group Type Management
     * @subgroup Listing Operations
     */
    public function index($typeId)
    {
        $type = Type::findOrFail($typeId);
        $metas = $type->metas;
        return response()->json([
            'type' => $type,
            'metas' => $metas
        ]);
    }

    /**
     * Create a new meta field for a type.
     * @group Type Management
     * @subgroup Form Operations
     */
    public function create($typeId)
    {
        $type = Type::findOrFail($typeId);
        return response()->json([
            'type' => $type
        ]);
    }

    /**
     * Store a new meta field for a type.
     * @group Type Management
     * @subgroup Form Operations
     */
    public function store(Request $request, $typeId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
        ]);

        $type = Type::findOrFail($typeId);
        $meta = $type->metas()->create($request->all());

        return response()->json([
            'message' => 'Meta field created successfully',
            'meta' => $meta
        ], 201);
    }

    /**
     * Display the specified meta field.
     * @group Type Management
     * @subgroup View Operations
     */
    public function show($typeId, TypeMeta $typeMeta)
    {
        return response()->json([
            'meta' => $typeMeta
        ]);
    }

    /**
     * Show the form for editing the meta field.
     * @group Type Management
     * @subgroup Form Operations
     */
    public function edit($typeId, TypeMeta $typeMeta)
    {
        return response()->json([
            'meta' => $typeMeta
        ]);
    }

    /**
     * Update the specified meta field.
     * @group Type Management
     * @subgroup Update Operations
     */
    public function update(Request $request, $typeId, TypeMeta $typeMeta)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'field_type' => 'required|string|max:255',
        ]);

        $typeMeta->update($request->all());

        return response()->json([
            'message' => 'Meta field updated successfully',
            'meta' => $typeMeta
        ]);
    }

    /**
     * Remove the specified meta field.
     * @group Type Management
     * @subgroup Delete Operations
     */
    public function destroy($typeId, TypeMeta $typeMeta)
    {
        $typeMeta->delete();
        return response()->json([
            'message' => 'Meta field deleted successfully'
        ]);
    }
}