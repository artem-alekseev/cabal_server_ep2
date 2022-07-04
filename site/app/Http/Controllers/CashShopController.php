<?php

namespace App\Http\Controllers;

use App\Models\CashItem;
use App\Models\Character;
use App\Models\Dictionaries\CashShopCategoriesDictionary;
use App\Models\ShopItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CashShopController extends Controller
{
    public function login(): View
    {
        $onlineAccountCount = User::where('Login', 1)->count();
        $accountCount = User::count();
        $charactersCount = Character::count();

        return view('cashshop.login', compact(
            'onlineAccountCount',
            'accountCount',
            'charactersCount'
        ));
    }

    public function index(): View
    {
        $user = auth()->user();

        if (!$user->bank) {
            $user->bank()->create();
        }

        $user = $user->load(['bank', 'warehouse']);

        return view('cashshop.index', compact('user'));
    }

    public function view(Request $request): View
    {
        $user = auth()->user();

        if (!$user->bank) {
            $user->bank()->create();
        }

        $user = $user->load(['bank', 'warehouse']);

        $cashShopCategories = CashShopCategoriesDictionary::getDictionary();
        $shopItems = ShopItem::where(['Category' => $request->get('tab', 1),])
            ->where('Available', '>', 0)
            ->get();

        return view('cashshop.view', compact('user', 'cashShopCategories', 'shopItems'));
    }

    public function deposit(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->Login)
        {
            $user->bank->update(['Alz' => $user->bank->Alz + $request->get('Alz', 0)]);
            $user->warehouse->update(['Alz' => $user->warehouse->Alz - $request->get('Alz', 0)]);
        }

        return redirect()->route('cashshop.index');
    }

    public function withdraw(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->Login)
        {
            $user->bank()->update(['Alz' => $user->bank->Alz - $request->get('Alz', 0)]);
            $user->warehouse()->update(['Alz' => $user->warehouse->Alz + $request->get('Alz', 0)]);
        }

        return redirect()->route('cashshop.index');
    }

    public function buy(Request $request): RedirectResponse
    {
        $item = ShopItem::find($request->get('itemId'));
        $user = auth()->user();

        if ($item->Available > 0 && $user->bank->Alz >= $item->Alz) {
            CashItem::create([
                'UserNum' => $user->UserNum,
                'TranNo' => 1,
                'ServerIdx' => 25,
                'ItemKindIdx' => $item->ItemIdx,
                'ItemOpt' => $item->ItemOpt,
                'DurationIdx' => $item->DurationIdx,
            ]);

            $item->update(['Available' => $item->Available - 1]);
            $user->bank->update(['Alz' => $user->bank->Alz - $item->Alz]);
        }

        return redirect()->route('cashshop.view');
    }

    public function itemList(): View
    {
        $shopItems = ShopItem::orderBy('Category')->get();

        return view('cashshop.list', compact('shopItems'));
    }

    public function edit(ShopItem $shopItem): View
    {
        $cashShopCategories = CashShopCategoriesDictionary::getDictionary();

        return view('cashshop.edit', compact('shopItem', 'cashShopCategories'));
    }

    public function create(): View
    {
        $cashShopCategories = CashShopCategoriesDictionary::getDictionary();

        return view('cashshop.create', compact('cashShopCategories'));
    }

    public function update(ShopItem $shopItem, Request $request): RedirectResponse
    {
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');

            $imageName = $shopItem->Id . '.' . $file->getClientOriginalExtension();

            $file->storeAs('/', $imageName, 'cashshop');

            $shopItem->update(['Image' => 'images/cashshop/items/' . $imageName]);
        }

        $shopItem->update($request->except('Image'));

        return redirect()->route('admin.cashshop.list');
    }

    public function store(Request $request): RedirectResponse
    {
        $shopItem = ShopItem::create($request->except('Image'));

        if ($request->hasFile('Image')) {
            $file = $request->file('Image');

            $imageName = $shopItem->Id . '.' . $file->getClientOriginalExtension();

            $file->storeAs('/', $imageName, 'cashshop');

            $shopItem->update(['Image' => 'images/cashshop/items/' . $imageName]);
        }

        return redirect()->route('admin.cashshop.list');
    }

    public function delete(ShopItem $shopItem): RedirectResponse
    {
        $shopItem->delete();

        return redirect()->route('admin.cashshop.list');
    }
}
