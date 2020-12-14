<div class="row text-row">
    {!! Form::label('question','Въпрос:') !!}
    <span class="warning">{{$errors->first('name')}}</span>
    {!! Form::textarea('name',null,['class' => 'groups-description', 'placeholder'=>'Моля въведете']) !!}
</div>
<div class="row">
    {!! Form::label('type','Тип:') !!}
    <span class="warning">{{$errors->first('type')}}</span>
    <div class="radios-wrapper">
        {!! Form::radio('type', '1', old('type') === '1') !!}
        <p>Да/Не</p>
        {!! Form::radio('type', '2', old('type') === '2') !!}
        <p>Отворен</p>
    </div>
</div>
{!! Form::submit($submitButtonText,['class'=>'red-btn setting-btn']) !!}
