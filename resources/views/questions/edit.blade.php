@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Редактиране на въпрос</p>
        {!! Form::model($question,['method'=>'PATCH','route'=>['questions.update', $question]]) !!}
        @include('questions/form',['submitButtonText'=>'Редактирай'])
        {!! Form::close() !!}
    </div>
@stop
