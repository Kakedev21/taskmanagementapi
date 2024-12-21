<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Models\Label;
use Illuminate\Http\JsonResponse;

class CardLabelController extends Controller
{
    public function attach(Request $request, Card $card)
    {
        $this->authorize('update', $card->list->board);

        $request->validate([
            'label_id' => 'required|exists:labels,id'
        ]);

        $card->labels()->attach($request->label_id);

        return response()->json($card->load('labels'));
    }

    public function detach(Card $card, Label $label)
    {
        $this->authorize('update', $card->list->board);

        $card->labels()->detach($label->id);

        return response()->json($card->load('labels'));
    }
}
