<?php

namespace App\Http\Controllers\Api;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @group Content Management
     * @subgroup Listing Operations
     */
    public function index()
    {
        return Content::all();
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @group Content Management
     * @subgroup Form Operations
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @group Content Management
     * @subgroup Create Operations
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'slug' => 'required|unique:contents',
            'type' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
            'content' => 'nullable|string',
            'meta' => 'nullable|json',
            'parent_id' => 'nullable|exists:contents,id',
            'level' => 'nullable|integer|min:0',
            'order' => 'nullable|integer|min:0'
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Content created successfully',
            'data' => Content::create($validated)
        ], 201);
    }

    /**
     * Display the specified resource.
     * 
     * @group Content Management
     * @subgroup View Operations
     */
    public function show($id)
    {
        $content = Content::findOrFail($id);
        
        return response()->json([
            'content' => $content,
            'breadcrumb' => $content->getBreadcrumbArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @group Content Management
     * @subgroup Form Operations
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * 
     * @group Content Management
     * @subgroup Update Operations
     */
    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'body' => 'sometimes|required',
            'slug' => 'sometimes|required|unique:contents,slug,' . $content->id,
            'is_active' => 'boolean',
            'parent_id' => 'sometimes|nullable|exists:contents,id',
            'level' => 'sometimes|nullable|integer|min:0',
            'order' => 'sometimes|nullable|integer|min:0'
        ]);

        $content->update($validated);
        return response()->json([
            'status' => true,
            'message' => 'Content updated successfully',
            'data' => $content
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @group Content Management
     * @subgroup Delete Operations
     */
    public function destroy(Content $content)
    {
        try {
            $content->delete();
            return response()->json([
                'message' => 'Content deleted successfully',
                'success' => true
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error occurred while deleting content',
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
