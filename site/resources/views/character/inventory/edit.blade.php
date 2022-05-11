@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>Edit {{ $item->dec_id ?? "New" }} item Hex : {{ $item->hex }}</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('item.save', [$character, $item->dec_position]) }}" method="POST">
                            @csrf
                            {{--                            <div class="mb-3">--}}
                            {{--                                <label for="bound" class="form-label">Bound</label>--}}
                            {{--                                <input id="bound" name="bound" type="text" class="form-control" value="{{ $item->bound }}">--}}
                            {{--                            </div> --}}

                            <item-editor :item="{{ json_encode($item) }}"
                                         :items="{{ json_encode($items) }}"></item-editor>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-outline-success">Submit</button>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('character.index', $character) }}" class="btn btn-outline-primary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
