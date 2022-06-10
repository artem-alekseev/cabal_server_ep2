@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Item to user: {{ $user->ID }}</h4>
                    </div>
                    <div class="card-body">
                        @include('layouts.errors')
                        <form action="{{ route('user.send_item', $user) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Item ID</label>
                                <input class="form-control" name="ItemKindIdx" value="{{ old('ItemKindIdx') }}">
                            </div>
                            <div class="mb-3">
                                <label>Item Option</label>
                                <input class="form-control" name="ItemOpt" value="{{ old('ItemOpt') }}">
                            </div>
                            <div class="mb-3">
                                <div class="btn-group float-end" role="group">
                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                                    <a href="{{ route('home') }}"
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
