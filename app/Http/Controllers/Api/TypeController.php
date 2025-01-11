<?php

namespace App\Http\Controllers\Api;
use Illuminate\Routing\Controller;

use App\Models\Type;
use Illuminate\Http\Request;


class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return response()->json($types);
    }

    public function show(Type $type)
    {
        return response()->json($type);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $type = Type::create($request->all());
        return response()->json([
            'message' => 'Type created successfully',
            'data' => $type
        ], 201);
    }

    public function update(Request $request, Type $type)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $type->update($request->all());
        return response()->json([
            'message' => 'Type updated successfully',
            'data' => $type
        ]);
    }

    public function destroy(Type $type)
    {
        $type->delete();
        return response()->json([
            'message' => 'Type deleted successfully'
        ]);
    }
}