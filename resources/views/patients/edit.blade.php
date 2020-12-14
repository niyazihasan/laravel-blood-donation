@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Редактиране на пациент</p>
        {!! Form::model($user,['method'=>'PATCH','route'=>['patients.update', $user]]) !!}
        @include('patients/form',['submitButtonText'=>'Редактирай'])
        {!! Form::close() !!}
    </div>
@stop
