<div class="row">
    {!! Form::label('name','Име:') !!}
    <span class="warning">{{$errors->first('name')}}</span>
    {!! Form::text('name',null,['placeholder'=>'Моля въведете']) !!}
</div>
<div id="user_hospital" class="row">
    {!! Form::label('city_id','Град:') !!}
    <span class="warning">{{$errors->first('city_id')}}</span>
    {!! Form::select('city_id',$cities,null,['placeholder'=>'-избери-', 'class' => 'rounded-dropdown']) !!}
</div>
{!! Form::submit($submitButtonText,['class'=>'red-btn setting-btn']) !!}
