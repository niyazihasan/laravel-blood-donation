@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__step">СТЪПКА 1</p>
        <p class="user-info__title">МОЛЯ ОТГОВОРЕТЕ НА СЛЕДНИТЕ ВЪПРОСИ</p>
        {!! Form::model($answer=new App\Models\Answer,['class' => 'user-info__form','method' =>'POST','route'=>['answers.store.one']]) !!}
        @foreach($declaration->questions as $question)
            <div class="row">
                {!! Form::label('question',$loop->iteration.'. '.$question->name) !!}
                <div class="radios-wrapper">
                    @if($question->type === App\Models\Question::TYPE_OPEN)
                        <input name="answer[{{$question->id}}]" type="radio" value="yes"
                            {{ old('answer.' . $question->id) === "yes" ? 'checked' : '' }}>
                        <p>Да</p>
                        <input name="answer[{{$question->id}}]" type="radio" value="no"
                            {{ old('answer.' . $question->id) === "no" ? 'checked' : '' }}>
                        <p>Не</p>
                    @else
                        {!! Form::text('answer['.$question->id.']',null,[
                                        'style'=>'width: 1000%;','placeholder'=>'Моля въведете',
                                        'autocomplete' => 'off'
                         ]) !!}
                    @endif
                    <span class="warning">{{$errors->first('answer.' . $question->id)}}</span>
                </div>
            </div>
        @endforeach
        {!! Form::button('КЪМ СЛЕДВАЩА СТЪПКА >>',['type' => 'submit','class' => 'red-btn setting-btn']) !!}
        {!! Form::close() !!}
    </div>
@stop
