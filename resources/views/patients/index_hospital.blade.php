@extends('layouts.app')
@section('body')
    <div class="user-info tables">
        <p class="user-info__title">Болница: {{$hospital->name}}, град: {{$hospital->city->name}}</p>
        <p class="user-info__title">Списък от пациенти</p>
        <a class="action-btn" href="{{route('patients.create')}}">
            <i class="fas fa-plus"></i> Добави пациент
        </a>
        <table class="table">
            <tr>
                <th>№</th>
                <th>Име, Презиме, Фамилия</th>
                <th>Години</th>
                <th>Кръвна група</th>
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
                    <td>{{$patient->blood_group}}</td>
                    <td>{{$patient->blood_quantity}}</td>
                    <td>{{$patient->current_blood}}</td>
                    <td>{{$patient->created_at}}</td>
                    <td>{{$patient->updated_at}}</td>
                    <td>
                        <a class="action-btn" href="{{route('patients.edit', $patient)}}">
                            <i class="fas fa-pencil-alt"></i> Редактирай
                        </a>
                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $patient]]) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> Изтрий',['type' => 'submit','class' => 'action-btn']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop
