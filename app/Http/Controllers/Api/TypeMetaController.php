<?php

namespace App\Http\Controllers\Api;

use App\Models\Type;
use App\Models\TypeMeta;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class TypeMetaController extends Controller
{
    public function index($typeId)
    {
        $type = Type::findOrFail($typeId);
        $metas = $type->metas;
        return response()->json([
            'type' => $type,
            'metas' => $metas
        ]);
    }

    public function create($typeId)
    {
        $type = Type::findOrFail($typeId);
        return response()->json([
            'type' => $type
        ]);
    }

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

    public function show($typeId, TypeMeta $typeMeta)
    {
        return response()->json([
            'meta' => $typeMeta
        ]);
    }

    public function edit($typeId, TypeMeta $typeMeta)
    {
        return response()->json([
            'meta' => $typeMeta
        ]);
    }

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

    public function destroy($typeId, TypeMeta $typeMeta)
    {
        $typeMeta->delete();
        return response()->json([
            'message' => 'Meta field deleted successfully'
        ]);
    }
}