@extends('layouts.app')
@section('body')
    <div class="user-info tables">
        <p class="user-info__title">Списък от всички декларациии</p>
        <a class="action-btn" href="{{route('declarations.create')}}">
            <i class="fas fa-plus"></i> Добави декларация
        </a>
        <table class="table">
            <tr>
                <th>№</th>
                <th>Име</th>
                <th>Брой въпроси</th>
                <th>Активност</th>
                <th>Дата на добавяне</th>
                <th>Дата на редактиране</th>
                <th>Действия</th>
            </tr>
            @foreach($declarations as $declaration)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$declaration->name}}</td>
                    <td>{{$declaration->questions_count}}</td>
                    <td>
                        {!! Form::open(['method' => 'PATCH','route' => ['declarations.update.activity', $declaration]]) !!}
                        {!! Form::hidden('active', $declaration->toogleActive()) !!}
                        <button type="submit" class="action-btn">
                            @if($declaration->isActive())
                                Деактивирай
                            @else
                                Активирай
                            @endif
                        </button>
                        {!! Form::close() !!}
                    </td>
                    <td>{{$declaration->created_at}}</td>
                    <td>{{$declaration->updated_at}}</td>
                    <td>
                        <a class="action-btn" href="{{route('declarations.show', $declaration)}}">
                            <i class="fas fa-eye"></i> Избери
                        </a>
                        <a class="action-btn" href="{{route('declarations.edit', $declaration)}}">
                            <i class="fas fa-pencil-alt"></i> Редактирай
                        </a>
                        {!! Form::open(['method' => 'DELETE','route' => ['declarations.destroy', $declaration]]) !!}
                        {!! Form::button('<i class="fa fa-trash"></i> Изтрий', ['type' => 'submit', 'class' => 'action-btn']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop
