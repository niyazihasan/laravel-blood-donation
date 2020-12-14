@extends('layouts.app')
@section('body')
    <div class="tabs-wrapper">
        <ul class="tabs">
            <li><a href="#tab1" class="tab-active">Доктори</a></li>
            <li><a href="#tab2">Пациенти</a></li>
        </ul>
        <div id="tab1" class="user-info tables">
            <p class="user-info__title">Болница: {{$hospital->name}}, град: {{$hospital->city->name}}</p>
            <p class="user-info__title">Списък от доктори</p>
            <table class="table">
                <tr>
                    <th>№</th>
                    <th>Име, Презиме, Фамилия</th>
                    <th>Email</th>
                    <th>Дата на добавяне</th>
                    <th>Дата на редактиране</th>
                    <th>Активност</th>
                    <th>Действия</th>
                </tr>
                @foreach($hospital->doctors as $doctor)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$doctor->full_name}}</td>
                        <td>{{$doctor->email}}</td>
                        <td>{{$doctor->created_at}}</td>
                        <td>{{$doctor->updated_at}}</td>
                        <td>{{$doctor->active}}</td>
                        <td>
                            <a class="action-btn" href="{{route('users.edit', $doctor)}}">
                                <i class="fas fa-pencil-alt"></i> Редактирай
                            </a>
                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $doctor]]) !!}
                            {!! Form::button('<i class="fa fa-trash"></i> Изтрий', ['type' => 'submit', 'class' => 'action-btn']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div id="tab2" class="user-info tables">
            <p class="user-info__title">Болница: {{$hospital->name}}, град: {{$hospital->city->name}}</p>
            <p class="user-info__title">Списък от пациенти</p>
            <table class="table">
                <tr>
                    <th>№</th>
                    <th>Име, Презиме, Фамилия</th>
                    <th>Години</th>
                    <th>Нужни донори</th>
                    <th>Намерени донори</th>
                    <th>Дата на добавяне</th>
                    <th>Дата на редактиране</th>
                    <th>Действия</th>
                </tr>
                @foreach($hospital->allPatients as $patient)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$patient->full_name}}</td>
                        <td>{{$patient->age}}</td>
                        <td>{{$patient->blood_quantity}}</td>
                        <td>{{$patient->current_blood}}</td>
                        <td>{{$patient->created_at}}</td>
                        <td>{{$patient->updated_at}}</td>
                        <td>
                            <a class="action-btn" href="{{route('patients.edit', $patient)}}">
                                <i class="fas fa-pencil-alt"></i> Редактирай
                            </a>
                            {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $patient->id]]) !!}
                            {!! Form::button('<i class="fa fa-trash"></i> Изтрий', ['type' => 'submit', 'class' => 'action-btn']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop
