@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <h3 class="card-header">
                        Skill List character : {{ $character->Name }}
                        <div class="btn-group float-end" role="group">
                            <a class="btn btn-outline-primary"
                               href="{{ route('character.index', $character) }}">Back</a>
                        </div>
                    </h3>
                    <div class="card-body">
                        <form id="save-form" action="{{ route('skill.save', [$character]) }}" method="POST">
                            <input id="position" type="hidden" name="position">
                            @csrf
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="border-dark border-2">-</th>
                                    <th class="border-dark border-2"> Sword Skills</th>
                                    <th class="border-dark border-2"> Magic Skills</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($i = 0; $i < 32; $i++)
                                    @php
                                        $swordSkill = $character->skillList->Data->firstWhere('dec_position', '=', $i);
                                        $magicSkill = $character->skillList->Data->firstWhere('dec_position', '=', $i + 32);
                                    @endphp

                                    <tr>
                                        <td class="border-2">{{ $i +1 }}</td>
                                        <td class="border-2">
                                            <select class="form-select-sm" name="skill_id[{{ $i }}]">
                                                @foreach($skillDictionary as $skillId => $skillName)
                                                    <option value="{{ $skillId }}"
                                                            @if($swordSkill?->dec_id == $skillId) selected @endif>{{ $skillName }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-sm btn-success float-end" type="button"
                                                    onclick="document.getElementById('position').value = {{ $i }};document.getElementById('save-form').submit()">
                                                Change
                                            </button>
                                        </td>
                                        <td class="border-2">
                                            <select class="form-select-sm" name="skill_id[{{ $i + 32 }}]">
                                                @foreach($skillDictionary as $skillId => $skillName)
                                                    <option value="{{ $skillId }}"
                                                            @if($magicSkill?->dec_id == $skillId) selected @endif>{{ $skillName }}</option>
                                                @endforeach
                                            </select>
                                            <button class="btn btn-sm btn-success float-end" type="button"
                                                    onclick="document.getElementById('position').value = {{ $i + 32 }};document.getElementById('save-form').submit()">
                                                Change
                                            </button>
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
