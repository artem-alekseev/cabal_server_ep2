<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user()->load('characters');

        return view('home', compact('user'));
    }

    public function editItem(Character $character, $item)
    {
        $item = $character->inventory->Data->firstWhere('dec_position', '=', $item);

        return view('character.inventory.edit', compact('item', 'character'));
    }

    public function saveItem(Character $character, $item, Request $request)
    {
        $item = $character->inventory->Data->firstWhere('dec_position', '=', $item);

        $item->update($request->except(['_token']));

        $character->inventory->save();

        return redirect(route('item.edit', [$character, $item->dec_position]));
    }
}
