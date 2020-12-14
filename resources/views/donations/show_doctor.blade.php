@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">
            Декларация на донор: {{$donation->donor->full_name}},
            Години: {{$donation->donor->age}},
            <br>с ЕГН: {{$donation->donor->egn}},
            град: {{$donation->donor->city->name}},
            пол: {{$donation->donor->gender}},
            <br> дата: {{$donation->declaration_date}}
        </p>
        <div class="user-info__form">
            @foreach($donation->donorDeclaration->answers as $answer)
                <div class="row">
                    {!! Form::label('question',$loop->iteration.'. '.$answer->question->name) !!}
                    <div class="radios-wrapper">
                        @if($answer->question->type === App\Models\Question::TYPE_OPEN)
                            <input disabled="disabled" type="radio" {{$answer->name == "yes" ? 'checked' : ''}} value="yes">
                            <p>Да</p>
                            <input disabled="disabled" type="radio" {{$answer->name == "no" ? 'checked' : ''}} value="no">
                            <p>Не</p>
                        @else
                            {!! Form::text('answer',$answer->name,[
                                                'style'=>'width: 1000%;','placeholder'=>'Моля въведете',
                                                'disabled' => 'disabled'
                                 ]) !!}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <label class="important-text">
                Дарява за:
                @if($donation->patient)
                    {{$donation->patient->full_name}}, в блница
                    {{$donation->patient->hospital->name}}, град:
                    {{$donation->patient->hospital->city->name}}.
                @else
                    безвъзмездно.
                @endif
            </label>
        </div>
        @if(!$donation->flag)
            {!! Form::model($donation,['method'=>'PATCH','route'=>['declarations.update.doctor', $donation]]) !!}
            <div class="row text-row">
                <label class="groups-text">Кръвна група:</label>
                <span class="warning">{{$errors->first('blood_type')}}</span>
                {!! Form::select('blood_type',$donation->donor->bloodTypes,$donation->donor->blood_type,['class' => 'rounded-dropdown blood_type']) !!}
            </div>
            <div class="row text-row">
                {!! Form::label('description','Наблюдения/забележки:') !!}
                <span class="warning">{{$errors->first('description')}}</span>
                {!! Form::textarea('description',$donation->description,['class' => 'groups-description']) !!}
            </div>
            {!! Form::button('Запамети',['type' => 'submit','class' => 'red-btn setting-btn']) !!}
            {!! Form::close() !!}
        @else
            <div class="row text-row">
                <label class="groups-text">Кръвна група:</label>
                {!! Form::select('blood_type',$donation->donor->bloodTypes,$donation->donor->blood_type,['disabled', 'class' => 'rounded-dropdown blood_type']) !!}
            </div>
            <div class="row text-row">
                <br/>{!! Form::label('description','Наблюдения/забележки:') !!}
                {!! Form::textarea('description',$donation->description,['disabled','class' => 'groups-description']) !!}
            </div>
            <br/><div class="row important-text">Одобрен от: д-р {{$donation->doctor->full_name}}</div>
        @endif
    </div>
@stop
