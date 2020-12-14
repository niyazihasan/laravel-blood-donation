@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__step">СТЪПКА 2</p>
        <p class="user-info__title">ИЗБЕРЕТЕ ЧОВЕКА НА КОГОТО ИСКАТЕ ДА ДАРИТЕ КРЪВ</p>
        {!! Form::model($answer=new App\Models\Donation,['class' => 'user-info__form step-two','method' =>'POST','route'=>['answers.store.two']]) !!}
        <div class="row">
            <div id="warning"></div>
            <div class="search-container">
                <input data-route="{{route('answers.autoload')}}"
                       autocomplete="off" name="patient" id="search" value="{{old('patient')}}"
                       type="text" placeholder="Търсете по име..." oninput="getAsyncResult()">
                <i class="delete-result fas fa-times"></i>
                <input name="search" id="hiddenVal" type="hidden" value="{{old('search')}}">
                <span class="warning">{{$errors->first('search')}}</span>
            </div>
            <div id="result"></div>
        </div>
        <div class="row">
            <p class="row__title">ИЛИ ОСТАВЕТЕ НИЕ ДА РЕШИМ:</p>
            <div class="radios-container">
                <input class="yours" type="radio" {{ old('flag') =="yes" ? 'checked' : '' }} name="flag" value="yes">
                <span>Да</span>
                <input class="yours" type="radio" {{ old('flag') =="no" ? 'checked' : '' }} name="flag" value="no">
                <span>Не</span>
                <span class="warning">{{$errors->first('flag')}}</span>
            </div>
        </div>
        {!! Form::button('<i class="fas fa-heart"></i>ДАРЕТЕ КРЪВ',['type' => 'submit','class' => 'red-btn setting-btn']) !!}
        {!! Form::close() !!}
    </div>
@stop
@section('js')
    <script type="text/javascript" src="{{asset("src/js/search.js")}}"></script>
@stop
