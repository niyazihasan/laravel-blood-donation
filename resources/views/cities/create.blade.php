@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Добавяне на нов град</p>
        {!! Form::model($city=new App\Models\City,['method'=>'post','route'=>['cities.store']]) !!}
        @include('cities/form',['submitButtonText'=>'Добави'])
        {!! Form::close() !!}
    </div>
@stop
