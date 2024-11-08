<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\List;
use Illuminate\Http\Request;
use App\Http\Resources\ListResource;

class ListController extends Controller
{
    public function index(Board $board)
    {
        $this->authorize('view', $board);
        $lists = $board->lists()->orderBy('position')->get();
        return ListResource::collection($lists);
    }

    public function store(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|integer|min:0',
        ]);

        $list = $board->lists()->create($validated);
        return new ListResource($list);
    }

    public function update(Request $request, Board $board, Lists $list)
    {
        $this->authorize('update', $board);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|integer|min:0',
        ]);

        $list->update($validated);
        return new ListResource($list);
    }

    public function destroy(Board $board, Lists $list)
    {
        $this->authorize('update', $board);
        $list->delete();
        return response()->json(null, 204);
    }
}