@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Добавяне на нова болница</p>
        {!! Form::model($hospital=new App\Models\Hospital,['method'=>'post','route'=>['hospitals.store']]) !!}
        @include('hospitals/form',['submitButtonText'=>'Добави'])
        {!! Form::close() !!}
    </div>
@stop
