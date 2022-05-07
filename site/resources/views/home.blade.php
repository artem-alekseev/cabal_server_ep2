@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>{{ __('Account Info') }}</h4></div>

                    <div class="card-body">
                        <h2>ID - {{ $user->ID }}</h2>
                        <p>Online - {{ $user->Login ? 'Yes' : "No" }}</p>
                        <p>Last online time - {{ $user->LogoutTime }}</p>

                        @foreach($user->characters as $character)
                            <h2>Character Name - {{ $character->Name }}</h2>
                            <p>Level - {{ $character->LEV }}</p>
                            <p>STR - {{ $character->STR }}</p>
                            <p>DEX - {{ $character->DEX }}</p>
                            <p>INT - {{ $character->INT }}</p>
                            <p>Alz - {{ $character->Alz }}</p>
                            <p>Nation - {{ $character->Nation }}</p>
                            <p>CreateDate - {{ $character->CreateDate }}</p>
                            <h2>Inventory - Page 1</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        @for($i = 0; $i < 8 ;$i++)
                                        <th>
                                            Slot
                                        </th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i = 0; $i < 8 ;$i++)
                                    <tr>
                                        @for($j = 0; $j < 8 ;$j++)
                                        <td>
                                            @php $slot = $i * 8 + $j; $item = $character->inventory->Data->firstWhere('dec_position', '=', $slot); @endphp
                                            SLOT #{{ $slot }}<br>
                                            Item : {{ $item ? $item->dec_id : '-' }}<br>
                                            @if ($item)
                                                <a href="{{ route('item.edit', [$character, $item->dec_position]) }}" class="btn btn-success">
                                                    Edit
                                                </a>
                                            @endif
                                        </td>
                                        @endfor
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
