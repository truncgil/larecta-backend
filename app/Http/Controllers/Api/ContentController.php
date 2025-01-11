<?php

namespace App\Http\Controllers\Api;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Content::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
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
            'meta' => 'nullable|json'
        ]);
        return response()->json(Content::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        return $content;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'body' => 'sometimes|required',
            'slug' => 'sometimes|required|unique:contents,slug,' . $content->id,
            'is_active' => 'boolean'
        ]);

        $content->update($validated);
        return $content;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        $content->delete();
        return response()->noContent();
    }
}
