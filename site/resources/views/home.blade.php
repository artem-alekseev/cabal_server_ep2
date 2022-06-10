@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card  text-center">
                    <h3 class="card-header">
                        Account : {{ $user->ID }}
                        <div class="btn-group float-end" role="group">
                            <a class="btn btn-outline-primary" href="{{ route('user.add_item', $user) }}">Give Item</a>
                            <a class="btn btn-outline-primary" href="{{ route('user.edit', $user) }}">Premium</a>
                        </div>
                    </h3>

                    <div class="card-body">
                        <p>Online - {{ $user->Login ? 'Yes' : "No" }}</p>
                        <p>Last online time - {{ $user->LogoutTime }}</p>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Character Name</th>
                                    <th>Level</th>
                                    <th>STR</th>
                                    <th>DEX</th>
                                    <th>INT</th>
                                    <th>Alz</th>
                                    <th>Nation</th>
                                    <th>CreateDate</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->characters as $character)
                                    <tr>
                                        <td>{{ $character->Name }}</td>
                                        <td>{{ $character->LEV }}</td>
                                        <td>{{ $character->STR }}</td>
                                        <td>{{ $character->DEX }}</td>
                                        <td>{{ $character->INT }}</td>
                                        <td>{{ $character->Alz }}</td>
                                        <td>{{ $character->Nation }}</td>
                                        <td>{{ $character->CreateDate }}</td>
                                        <td>
                                            <a class="btn btn-outline-primary" href="{{ route('character.index', $character) }}">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
