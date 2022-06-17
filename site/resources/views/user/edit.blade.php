@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit user: {{ $user->ID }}</h4>
                    </div>
                    <div class="card-body">
                        @include('layouts.errors')
                        <form action="{{ route('user.update', $user) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <select name="ServiceKind" class="form-control">
                                    @foreach($premiumTypes as $key => $name)
                                        <option @if($user->premium->ServiceKind == $key) selected @endif value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Expire Premium Date</label>
                                <input type="date" class="form-control" name="ExpireDate" value="{{ old('ExpireDate') ?? $user->premium?->ExpireDate->format('Y-m-d') }}">
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
