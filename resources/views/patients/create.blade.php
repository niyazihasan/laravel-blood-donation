@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Въведете данни за нуждаещия</p>
        {!! Form::model($user=new App\Models\User,['method'=>'POST','route'=>['patients.store']]) !!}
        @include('patients/form',['submitButtonText'=>'Добави'])
        {!! Form::close() !!}
    </div>
@stop
