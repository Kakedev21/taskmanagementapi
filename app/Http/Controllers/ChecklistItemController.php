<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChecklistItemController extends Controller
{
    public function store(Request $request, Checklist $checklist)
    {
        $this->authorize('update', $checklist->card->list->board);

        $request->validate([
            'title' => 'required|string|max:255'
        ]);

        $position = $checklist->items()->max('position') + 1;

        $item = $checklist->items()->create([
            'title' => $request->title,
            'position' => $position
        ]);

        return response()->json($item, 201);
    }

    public function update(Request $request, Checklist $checklist, ChecklistItem $item)
    {
        $this->authorize('update', $checklist->card->list->board);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'is_completed' => 'sometimes|boolean'
        ]);

        $item->update($request->all());

        return response()->json($item);
    }

    public function destroy(Checklist $checklist, ChecklistItem $item)
    {
        $this->authorize('update', $checklist->card->list->board);

        $item->delete();

        return response()->json(null, 204);
    }
}
