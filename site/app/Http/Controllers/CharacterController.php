<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Dictionaries\ItemDictionary;
use App\Models\Item;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index(Character $character)
    {
        $character->load('inventory');

        $closedClots = [];

        foreach ($character->inventory->Data as $item) {
            $closedClots = array_merge($closedClots, $item->closed_positions);
        }

        return view('character.index', compact('character', 'closedClots'));
    }

    public function editItem(Character $character, $position)
    {
        $item = $character->inventory->Data->firstWhere('dec_position', '=', $position);

        if (!$item) {
            $item = new Item($position);
        }

        $items = ItemDictionary::getDictionary();

        return view('character.inventory.edit', compact('item', 'character', 'items'));
    }

    public function saveItem(Character $character, $position, Request $request)
    {
        $item = $character->inventory->Data->firstWhere('dec_position', '=', $position) ?? new Item($position);

        $item->update($request->except(['_token']));

        if (!$item->exist) {
            $character->inventory->Data->push($item);
        }

        $character->inventory->save();

        return redirect('/');
    }
}
