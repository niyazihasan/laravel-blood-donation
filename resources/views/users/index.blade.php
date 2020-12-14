@extends('layouts.app')
@section('body')
    <div class="user-info tables">
        <p class="user-info__title">Списък от всички потребители</p>
        <a class="action-btn" href="{{route('users.create')}}">
            <i class="fas fa-plus"></i> Добави потребител
        </a>
        {!! Form::open(['method'=>'GET','route'=>['users.index'],'class' => 'users-form']) !!}
        <div class="row">
            {!! Form::select('role',$roles,$role,['placeholder'=>'-избери тип потребител-', 'class' => 'rounded-dropdown']) !!}
        </div>
        {!! Form::button('покажи',['type' => 'submit','class' => 'red-btn']) !!}
        {!! Form::close() !!}
        <table class="table">
            <tr>
                <th>№</th>
                <th>Email</th>
                <th>Тип</th>
                <th>Активност</th>
                <th>Действия</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->type}}</td>
                    <td>
                        @if($user->isActive())
                            Активен
                        @else
                            Не активен
                        @endif
                    </td>
                    <td>
                        <a class="action-btn" href="{{route('users.edit', $user)}}">
                            <i class="fas fa-pencil-alt"></i> Редактирай
                        </a>
                        {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user]]) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> Изтрий', ['type' => 'submit', 'class' => 'action-btn']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop
