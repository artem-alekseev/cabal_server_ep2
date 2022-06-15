<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\CashItem;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $user = auth()->user()->load('characters');

        return view('home', compact('user'));
    }

    public function edit(User $user): View
    {
        $user->load('premium');

        return view('user.edit', compact('user'));
    }

    public function update(User $user, UserUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated() + [
                'Type' => 5,
                'PayMinutes' => 99999,
                'ServiceKind' => 1
        ];

        $user->premium()->updateOrCreate(['UserNum' => $user->UserNum], $data);

        return redirect()->route('home');
    }

    public function addItem(User $user): View
    {
        $users = User::pluck('ID', 'UserNum');

        return view('user.add-item', compact('user', 'users'));
    }

    public function sendItem(User $user, Request $request): RedirectResponse
    {
        CashItem::create([
            'UserNum' => $request->get('UserNum') ? $request->get('UserNum') : $user->UserNum,
            'TranNo' => 1,
            'ServerIdx' => 25,
            'DurationIdx' => 31,
        ] + $request->all());

        return redirect()->route('home');
    }
}
