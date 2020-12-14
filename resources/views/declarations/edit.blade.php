@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Редактиране на декларация</p>
        {!! Form::model($declaration,['method'=>'PATCH','route'=>['declarations.update', $declaration]]) !!}
        @include('declarations/form',['submitButtonText'=>'Редактирай'])
        {!! Form::close() !!}
    </div>
@stop
