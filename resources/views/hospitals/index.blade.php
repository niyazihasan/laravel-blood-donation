@extends('layouts.app')
@section('body')
    <div class="user-info tables">
        <p class="user-info__title">Списък от всички болници</p>
        <a class="action-btn" href="{{route('hospitals.create')}}">
            <i class="fas fa-plus"></i> Добави болница
        </a>
        <table class="table">
            <tr>
                <th>№</th>
                <th>Име</th>
                <th>Град</th>
                <th>Дата на добавяне</th>
                <th>Дата на редактиране</th>
                <th>Действия</th>
            </tr>
            @foreach($hospitals as $hospital)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$hospital->name}}</td>
                    <td>{{$hospital->city->name}}</td>
                    <td>{{$hospital->created_at}}</td>
                    <td>{{$hospital->updated_at}}</td>
                    <td>
                        <a class="action-btn" href="{{route('hospitals.show', $hospital)}}">
                            <i class="fas fa-eye"></i> Избери
                        </a>
                        <a class="action-btn" href="{{route('hospitals.edit', $hospital)}}">
                            <i class="fas fa-pencil-alt"></i> Редактирай
                        </a>
                        {!! Form::open(['method' => 'DELETE','route' => ['hospitals.destroy', $hospital]]) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> Изтрий', ['type' => 'submit', 'class' => 'action-btn']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop
