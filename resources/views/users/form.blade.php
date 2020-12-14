<div class="row">
    {!! Form::label('email','Email:') !!}
    <span class="warning">{{$errors->first('email')}}</span>
    {!! Form::text('email',null,['placeholder'=>'Моля въведете']) !!}
</div>
<div class="row">
    {!! Form::label('password','Парола:') !!}
    <span class="warning">{{$errors->first('password')}}</span>
    <input type="password" class="password" name="password" value=""/>
</div>
<div class="row">
    {!! Form::label('role','Тип:') !!}
    <span class="warning">{{$errors->first('role')}}</span>
    {!! Form::select('role',$user->roles,null,['placeholder'=>'-избери-', 'id' => 'user_role', 'class' => 'rounded-dropdown']) !!}
</div>
<div id="user_hospital" class="row">
    {!! Form::label('hospital','Болница:') !!}
    <span class="warning">{{$errors->first('hospital_id')}}</span>
    {!! Form::select('hospital_id',$hospitals,null,['placeholder'=>'-избери-', 'class' => 'rounded-dropdown']) !!}
</div>
<div class="row">
    {!! Form::label('active','Активност:') !!}
    <span class="warning">{{$errors->first('active')}}</span>
    <div class="radios-wrapper">
        {!! Form::radio('active', '1', old('type') === '1') !!}
        <p>Активен</p>
        {!! Form::radio('active', '0', old('type') === '0') !!}
        <p>Не активен</p>
    </div>
</div>
{!! Form::submit($submitButtonText,['class'=>'red-btn setting-btn']) !!}
@section('js')
    <script type="text/javascript">
        $('#user_hospital').hide();
        $('#user_role').on('change', function () {
            $('#user_hospital').hide();
            if (this.value === 'ROLE_DOCTOR') {
                $('#user_hospital').show();
            }
        });
        $('#user_role').trigger('change');
    </script>
@stop
