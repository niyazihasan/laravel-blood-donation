<div class="row text-row">
    {!! Form::label('name','Име:') !!}
    <span class="warning">{{$errors->first('name')}}</span>
    {!! Form::text('name',$city->name,['placeholder'=>'Моля въведете']) !!}
</div>
{!! Form::submit($submitButtonText,['class'=>'red-btn setting-btn']) !!}
