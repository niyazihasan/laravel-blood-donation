@extends('layouts.app')
@section('body')
    <div class="user-info">
        <p class="user-info__title">Редактиране на потребителски данни</p>
        {!! Form::model($user,['method'=>'PATCH','route'=>['users.update.profile', $user]]) !!}
        <div class="row">
            <label>Email:</label>
            <span class="warning">{{$errors->first('email')}}</span>
            <input type="text" name="email" value="{{$user->email ?? old('email')}}"/>
        </div>
        <div class="row">
            <label>Парола:</label>
            <span class="warning">{{$errors->first('password')}}</span>
            <input type="password" name="password" value=""/>
        </div>
        <div class="row">
            <label>Име:</label>
            <span class="warning">{{$errors->first('name')}}</span>
            <input name="name" type="text" value="{{$user->name ?? old('name')}}"/>
        </div>
        <div class="row">
            <label>Презиме:</label>
            <span class="warning">{{$errors->first('fathersname')}}</span>
            <input name="fathersname" type="text" value="{{$user->fathersname ?? old('fathersname')}}"/>
        </div>
        <div class="row">
            <label>Фамилия:</label>
            <span class="warning">{{$errors->first('surname')}}</span>
            <input name="surname" type="text" value="{{$user->surname ?? old('surname')}}"/>
        </div>
        <div class="row">
            <label>Град:</label>
            <span class="warning">{{$errors->first('city_id')}}</span>
            {!! Form::select('city_id',$cities,$user->city->id ?? null,['placeholder'=>'-избери-', 'class' => 'rounded-dropdown city']) !!}
        </div>
        <div class="row">
            <label>Кръвна група:</label>
            <input disabled type="text" name="blood_type" value="{{$user->blood_group}}"/>
        </div>
        <div class="row">
            <label>ЕГН:</label>
            <span class="warning">{{$errors->first('egn')}}</span>
            <input type="text" name="egn" value="{{$user->egn ?? old('egn')}}"/>
        </div>
        @if(auth()->user()->role === App\Models\User::ROLE_DOCTOR)
            <div class="row">
                <label>Болница:</label>
                <input type="text" disabled value="{{$user->hospital->name}}"/>
            </div>
        @endif
        {!! Form::button('Запамети',['type' => 'submit','class' => 'red-btn setting-btn']) !!}
        {!! Form::close() !!}
    </div>
@stop
