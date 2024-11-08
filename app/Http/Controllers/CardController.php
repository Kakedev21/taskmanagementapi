<?php

namespace App\Http\Controllers;

use App\Models\List;
use App\Models\Card;
use Illuminate\Http\Request;
use App\Http\Resources\CardResource;

class CardController extends Controller
{
    public function index(Lists $list)
    {
        $this->authorize('view', $list->board);
        $cards = $list->cards()->orderBy('position')->get();
        return CardResource::collection($cards);
    }

    public function store(Request $request, Lists $list)
    {
        $this->authorize('update', $list->board);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'required|integer|min:0',
        ]);

        $card = $list->cards()->create($validated);
        return new CardResource($card);
    }

    public function update(Request $request, Lists $list, Card $card)
    {
        $this->authorize('update', $list->board);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'position' => 'required|integer|min:0',
            'list_id' => 'sometimes|exists:lists,id',
        ]);

        if (isset($validated['list_id']) && $validated['list_id'] != $list->id) {
            $card->list_id = $validated['list_id'];
            unset($validated['list_id']);
        }

        $card->update($validated);
        return new CardResource($card);
    }

    public function destroy(Lists $list, Card $card)
    {
        $this->authorize('update', $list->board);
        $card->delete();
        return response()->json(null, 204);
    }
}