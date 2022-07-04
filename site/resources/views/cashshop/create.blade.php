@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card  text-center">
                    <div class="card-header">
                        Cash Shop Create
                        <div class="btn-group float-end" role="group">
                            <a class="btn btn-outline-primary" href="{{ route('admin.cashshop.list') }}">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts.errors')
                        <form action="{{ route('admin.cashshop.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Name</label>
                                <input class="form-control" name="Name" value="{{ old('Name') }}">
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <input class="form-control" name="Description" value="{{ old('Description') }}">
                            </div>
                            <div class="mb-3">
                                <label>ItemIdx</label>
                                <input class="form-control" name="ItemIdx" value="{{ old('ItemIdx') }}">
                            </div>
                            <div class="mb-3">
                                <label>ItemOpt</label>
                                <input class="form-control" name="ItemOpt" value="{{ old('ItemOpt') }}">
                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <input class="form-control" type="file" name="Image" value="{{ old('Image') }}">
                            </div>
                            <div class="mb-3">
                                <label>Alz</label>
                                <input class="form-control" name="Alz" value="{{ old('Alz') }}">
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select class="form-control" name="Category">
                                    @foreach($cashShopCategories as $categoryCode => $categoryName)
                                        <option value="{{ $categoryCode }}">{{ $categoryName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Available</label>
                                <input class="form-control" name="Available" value="{{ old('Available') }}">
                            </div>
                            <div class="mb-3">
                                <label>Duration</label>
                                <input class="form-control" name="DurationIdx" value="{{ old('DurationIdx') }}">
                            </div>
                            <div class="mb-3">
                                <div class="btn-group float-end" role="group">
                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                                    <a href="{{ route('admin.cashshop.list') }}"
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
