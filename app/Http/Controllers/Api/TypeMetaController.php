<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use App\Models\TypeMeta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * @group Type Management
 * @subgroup TypeMeta Controller
 * This controller handles the CRUD operations for the TypeMeta model.
 */
class TypeMetaController extends Controller
{
    /**
     * @group Type Management
     * @subgroup Listing Operations
     * Get all meta fields for a type.
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
     * @group Type Management
     * @subgroup Form Operations
     * Create a new meta field for a type.
     */
    public function create($typeId)
    {
        $type = Type::findOrFail($typeId);
        return response()->json([
            'type' => $type
        ]);
    }

    /**
     * @group Type Management
     * @subgroup Form Operations
     * Store a new meta field for a type.
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
     * @group Type Management
     * @subgroup View Operations
     * Display the specified meta field.
     */
    public function show($typeId, TypeMeta $typeMeta)
    {
        return response()->json([
            'meta' => $typeMeta
        ]);
    }

    /**
     * @group Type Management
     * @subgroup Form Operations
     * Show the form for editing the meta field.
     */
    public function edit($typeId, TypeMeta $typeMeta)
    {
        return response()->json([
            'meta' => $typeMeta
        ]);
    }

    /**
     * @group Type Management
     * @subgroup Update Operations
     * Update the specified meta field.
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
     * @group Type Management
     * @subgroup Delete Operations
     * Remove the specified meta field.
     */
    public function destroy($typeId, TypeMeta $typeMeta)
    {
        $typeMeta->delete();
        return response()->json([
            'message' => 'Meta field deleted successfully'
        ]);
    }
}