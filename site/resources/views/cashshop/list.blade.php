@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card  text-center">
                    <h3 class="card-header">
                        Cash Shop List
                        <div class="btn-group float-end" role="group">
                            <a class="btn btn-outline-primary" href="{{ route('home') }}">Back</a>
                        </div>
                    </h3>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>ItemId</th>
                                    <th>ItemOption</th>
                                    <th>Image</th>
                                    <th>Alz</th>
                                    <th>Category</th>
                                    <th>Available</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shopItems as $item)
                                    <tr>
                                        <td>{{ $item->Name }}</td>
                                        <td>{{ $item->Description }}</td>
                                        <td>{{ $item->ItemIdx }}</td>
                                        <td>{{ $item->ItemOpt }}</td>
                                        <td><img width="128" height="128" src="{{ asset($item->Image) }}"></td>
                                        <td>{{ $item->Alz }}</td>
                                        <td>{{ $item->categoryName }}</td>
                                        <td>{{ $item->Available }}</td>
                                        <td>
                                            <a class="btn btn-outline-primary" href="{{ route('admin.cashshop.edit', $item) }}">Edit</a>
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
