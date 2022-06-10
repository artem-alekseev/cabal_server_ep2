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
                                <label>Alz</label>
                                <input class="form-control" name="Alz" value="{{ old('Alz') ?? $character->Alz }}">
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
