@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card  text-center">
                    <div class="card-header">
                        Cash Shop Edit : {{ $shopItem->Name }}
                        <div class="btn-group float-end" role="group">
                            <a class="btn btn-outline-primary" href="{{ route('admin.cashshop.list') }}">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts.errors')
                        <form action="{{ route('admin.cashshop.update', $shopItem) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Name</label>
                                <input class="form-control" name="Name" value="{{ old('Name') ?? $shopItem->Name }}">
                            </div>
                            <div class="mb-3">
                                <label>Description</label>
                                <input class="form-control" name="Description" value="{{ old('Description') ?? $shopItem->Description }}">
                            </div>
                            <div class="mb-3">
                                <label>ItemIdx</label>
                                <input class="form-control" name="ItemIdx" value="{{ old('ItemIdx') ?? $shopItem->ItemIdx }}">
                            </div>
                            <div class="mb-3">
                                <label>ItemOpt</label>
                                <input class="form-control" name="ItemOpt" value="{{ old('ItemOpt') ?? $shopItem->ItemOpt }}">
                            </div>
                            <img width="128" height="128" src="{{ asset($shopItem->Image) }}">
                            <div class="mb-3">
                                <label>Image</label>
                                <input class="form-control" type="file" name="Image" value="{{ old('Image') }}">
                            </div>
                            <div class="mb-3">
                                <label>Alz</label>
                                <input class="form-control" name="Alz" value="{{ old('Alz') ?? $shopItem->Alz }}">
                            </div>
                            <div class="mb-3">
                                <label>Category</label>
                                <select class="form-control" name="Category">
                                    @foreach($cashShopCategories as $categoryCode => $categoryName)
                                        <option value="{{ $categoryCode }}"
                                                @if ((old('Category') ?? $shopItem->Category) == $categoryCode) selected @endif>{{ $categoryName }}</option>
                                    @endforeach
                                </select>
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
