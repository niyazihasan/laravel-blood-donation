@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Добавяне на нов потребител</p>
        {!! Form::model($user=new App\Models\User,['method'=>'post','route'=>['users.store'], 'style' => 'align-items: center;']) !!}
        @include('users/form',['submitButtonText'=>'Добави'])
        {!! Form::close() !!}
    </div>
@stop
