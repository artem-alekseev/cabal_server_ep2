@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>Edit item {{ $item->dec_id }}</h4></div>

                    <div class="card-body">
                        <form action="{{ route('item.save', [$character, $item->dec_position]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="id" class="form-label">ID</label>
                                <input id="id" name="id" type="text" class="form-control" value="{{ $item->id }}">
                            </div>

                            <div class="mb-3">
                                <label for="lvl" class="form-label">Level</label>
                                <input id="lvl" name="lvl" type="text" class="form-control" value="{{ $item->lvl }}">
                            </div>

                            <div class="mb-3">
                                <label for="bound" class="form-label">Bound</label>
                                <input id="bound" name="bound" type="text" class="form-control" value="{{ $item->bound }}">
                            </div>

                            <div class="mb-3">
                                <label for="first_craft_slot" class="form-label">1 Craft Slot</label>
                                <input id="first_craft_slot" name="first_craft_slot" type="text" class="form-control" value="{{ $item->first_craft_slot }}">
                            </div>

                            <div class="mb-3">
                                <label for="first_craft_option" class="form-label">1 Craft Option</label>
                                <input id="first_craft_option" name="first_craft_option" type="text" class="form-control" value="{{ $item->first_craft_option }}">
                            </div>

                            <div class="mb-3">
                                <label for="two_craft_slot" class="form-label">2 Craft Slot</label>
                                <input id="two_craft_slot" name="two_craft_slot" type="text" class="form-control" value="{{ $item->two_craft_slot }}">
                            </div>

                            <div class="mb-3">
                                <label for="two_craft_option" class="form-label">2 Craft Option</label>
                                <input id="two_craft_option" name="two_craft_option" type="text" class="form-control" value="{{ $item->two_craft_option }}">
                            </div>

                            <div class="mb-3">
                                <label for="thrid_craft_slot" class="form-label">3 Craft Slot</label>
                                <input id="thrid_craft_slot" name="thrid_craft_slot" type="text" class="form-control" value="{{ $item->thrid_craft_slot }}">
                            </div>

                            <div class="mb-3">
                                <label for="thrid_craft_option" class="form-label">3 Craft Option</label>
                                <input id="thrid_craft_option" name="thrid_craft_option" type="text" class="form-control" value="{{ $item->thrid_craft_option }}">
                            </div>

                            <div class="mb-3">
                                <label for="count_slots" class="form-label">Count Slots</label>
                                <input id="count_slots" name="count_slots" class="form-control" type="text" value="{{ $item->count_slots }}">
                            </div>

                            <div class="mb-3">
                                <label for="four_craft_option" class="form-label">4 Craft Option</label>
                                <input id="four_craft_option" name="four_craft_option" class="form-control" type="text" value="{{ $item->four_craft_option }}">
                            </div>

                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
