@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Редактиране на град</p>
        {!! Form::model($city,['method'=>'PATCH','route'=>['cities.update', $city]]) !!}
        @include('cities/form',['submitButtonText'=>'Редактирай'])
        {!! Form::close() !!}
    </div>
@stop
