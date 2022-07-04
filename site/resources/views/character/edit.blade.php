@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit character: {{ $character->Name }}</h4>
                    </div>
                    <div class="card-body">
                        @include('layouts.errors')
                        <form action="{{ route('character.update', $character) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Name</label>
                                <input class="form-control" name="Name" value="{{ old('Name') ?? $character->Name }}">
                            </div>
                            <div class="mb-3">
                                <label>Level</label>
                                <input class="form-control" name="LEV" value="{{ old('LEV') ?? $character->LEV }}">
                            </div>
                            <div class="mb-3">
                                <label>STR</label>
                                <input class="form-control" name="STR" value="{{ old('STR') ?? $character->STR }}">
                            </div>
                            <div class="mb-3">
                                <label>DEX</label>
                                <input class="form-control" name="DEX" value="{{ old('DEX') ?? $character->DEX }}">
                            </div>
                            <div class="mb-3">
                                <label>INT</label>
                                <input class="form-control" name="INT" value="{{ old('INT') ?? $character->INT }}">
                            </div>
                            <div class="mb-3">
                                <label>PNT</label>
                                <input class="form-control" name="PNT" value="{{ old('PNT') ?? $character->PNT }}">
                            </div>
                            <div class="mb-3">
                                <label>Rank</label>
                                <input class="form-control" name="Rank" value="{{ old('Rank') ?? $character->Rank }}">
                            </div>
                            <div class="mb-3">
                                <label>Alz</label>
                                <input class="form-control" name="Alz" value="{{ old('Alz') ?? $character->Alz }}">
                            </div>
                            <div class="mb-3">
                                <label>Style</label>
                                <input class="form-control" name="Style" value="{{ old('Style') ?? $character->Style }}">
                            </div>
                            <div class="mb-3">
                                <label>SwdPNT</label>
                                <input class="form-control" name="SwdPNT" value="{{ old('SwdPNT') ?? $character->SwdPNT }}">
                            </div>
                            <div class="mb-3">
                                <label>MagPNT</label>
                                <input class="form-control" name="MagPNT" value="{{ old('MagPNT') ?? $character->MagPNT }}">
                            </div>
                            <div class="mb-3">
                                <label>RankEXP</label>
                                <input class="form-control" name="RankEXP" value="{{ old('RankEXP') ?? $character->RankEXP }}">
                            </div>
                            <div class="mb-3">
                                <label>WarpBField</label>
                                <input class="form-control" name="WarpBField" value="{{ old('WarpBField') ?? $character->WarpBField }}">
                            </div>
                            <div class="mb-3">
                                <label>MapsBField</label>
                                <input class="form-control" name="MapsBField" value="{{ old('MapsBField') ?? $character->MapsBField }}">
                            </div>
                            <div class="mb-3">
                                <label>SP</label>
                                <input class="form-control" name="SP" value="{{ old('SP') ?? $character->SP }}">
                            </div>
                            <div class="mb-3">
                                <label>Reputation</label>
                                <input class="form-control" name="Reputation" value="{{ old('Reputation') ?? $character->Reputation }}">
                            </div>
                            <div class="mb-3">
                                <label>Nation</label>
                                <select class="form-control" name="Nation">
                                    @foreach($characterNations as $nationCode => $nationName)
                                        <option value="{{ $nationCode }}"
                                                @if ((old('Nation') ?? $character->Nation) == $nationCode) selected @endif>{{ $nationName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="btn-group float-end" role="group">
                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                                    <a href="{{ route('character.index', $character) }}"
                                       class="btn btn-outline-primary">Back</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
