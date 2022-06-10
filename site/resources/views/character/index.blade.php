@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <h3 class="card-header">
                        View character : {{ $character->Name }}
                        <div class="btn-group float-end" role="group">
                            <a class="btn btn-outline-success" href="{{ route('character.edit', $character) }}">Edit</a>
                            <a class="btn btn-outline-primary" href="{{ route('home') }}">Back</a>
                        </div>
                    </h3>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>STR</th>
                                    <th>DEX</th>
                                    <th>INT</th>
                                    <th>Alz</th>
                                    <th>Nation</th>
                                    <th>CreateDate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $character->LEV }}</td>
                                    <td>{{ $character->STR }}</td>
                                    <td>{{ $character->DEX }}</td>
                                    <td>{{ $character->INT }}</td>
                                    <td>{{ $character->Alz }}</td>
                                    <td>{{ $character->Nation }}</td>
                                    <td>{{ $character->CreateDate }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @include('character.inventory.index', ['page' => 1])
                        @include('character.inventory.index', ['page' => 2])
                        @include('character.inventory.index', ['page' => 3])
                        @include('character.inventory.index', ['page' => 4])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
