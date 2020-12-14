@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Добавяне на нова декларация</p>
        {!! Form::model($declaration=new App\Models\Declaration,['method'=>'post','route'=>['declarations.store']]) !!}
        @include('declarations/form',['submitButtonText'=>'Добави'])
        {!! Form::close() !!}
    </div>
@stop
