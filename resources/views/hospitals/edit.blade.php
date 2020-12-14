@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Редактиране на болница</p>
        {!! Form::model($hospital,['method'=>'PATCH','route'=>['hospitals.update', $hospital]]) !!}
        @include('hospitals/form',['submitButtonText'=>'Редактирай'])
        {!! Form::close() !!}
    </div>
@stop
