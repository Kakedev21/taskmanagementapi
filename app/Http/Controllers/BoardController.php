<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use App\Http\Resources\BoardResource;

class BoardController extends Controller
{
    public function index()
    {
        $boards = auth()->user()->boards;
        return BoardResource::collection($boards);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board = auth()->user()->boards()->create($validated);
        return new BoardResource($board);
    }

    public function show(Board $board)
    {
        $this->authorize('view', $board);
        return new BoardResource($board);
    }

    public function update(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board->update($validated);
        return new BoardResource($board);
    }

    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);
        $board->delete();
        return response()->json(null, 204);
    }
}