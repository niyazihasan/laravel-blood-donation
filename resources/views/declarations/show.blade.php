@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">{{$declaration->name}}</p>
        <div class="user-info__form">
            @foreach($declaration->questions as $question)
                <div class="row">
                    <a href="{{route('questions.edit', $question)}}">
                        <i class="edit-question fas fa-pencil-alt"></i>
                    </a>
                    {!! Form::open(['method' => 'DELETE','route' => ['questions.destroy', $question]]) !!}
                    <button type="submit" class="action-btn">
                        <i class="delete-question fas fa-trash-alt"></i>
                    </button>
                    {!! Form::close() !!}
                    <label>{{ $loop->iteration.'. '.$question->name }}</label>
                </div>
            @endforeach
        </div>
        @include('questions/create')
    </div>
@stop
