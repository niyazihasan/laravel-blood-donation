@extends('layouts.app')
@section('body')
    <div class="user-info tables">
        <p class="user-info__title">Списък от чакащи кръв</p>
        <table class="table">
            <tr>
                <th>№</th>
                <th>Нуждаещ се</th>
                <th>Години</th>
                <th>Кръвна група</th>
                <th>Болница</th>
                <th>Нужни донори</th>
                @if(auth()->user()->role === App\Models\User::ROLE_ADMIN)
                    <th>Действия</th>
                @endif
            </tr>
            @foreach($patients as $patient)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$patient->full_name}}</td>
                    <td>{{$patient->age}}</td>
                    <td>{{$patient->blood_group}}</td>
                    <td>{{$patient->hospital->name}}, град: {{$patient->hospital->city->name}}</td>
                    <td>{{$patient->current_need_blood.' човек/а'}}</td>
                    @if(auth()->user()->role === App\Models\User::ROLE_ADMIN)
                        <td>
                            <a class="action-btn" href="{{route('patients.edit', $patient)}}">
                                <i class="fas fa-pencil-alt"></i> Редактирай
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@stop
