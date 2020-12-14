<div class="row">
    <label>Име:</label>
    <span class="warning">{{$errors->first('name')}}</span>
    <input type="text" name="name" value="{{$user->name ?? old('name')}}"/>
</div>
<div class="row">
    <label>Презиме:</label>
    <span class="warning">{{$errors->first('fathersname')}}</span>
    <input type="text" name="fathersname" value="{{$user->fathersname ?? old('fathersname')}}"/>
</div>
<div class="row">
    <label>Фамилия:</label>
    <span class="warning">{{$errors->first('surname')}}</span>
    <input type="text" name="surname" value="{{$user->surname ?? old('surname')}}"/>
</div>
<div class="row">
    <label>Кръвна група:</label>
    <span class="warning">{{$errors->first('blood_type')}}</span>
    {!! Form::select('blood_type',$user->bloodTypes,$user->blood_type,['class' => 'rounded-dropdown']) !!}
</div>
<div class="row">
    <label>Нужен кръв(брой донори):</label>
    <span class="warning">{{$errors->first('blood_quantity')}}</span>
    <input type="text" name="blood_quantity" value="{{$user->blood_quantity ?? old('blood_quantity')}}"/>
</div>
<div class="row">
    <label>Болница:</label>
    @if(!$user->hospital)
        {!! Form::text('hospital_id',auth()->user()->hospital->name,['disabled', 'class' => 'rounded-dropdown hospital']) !!}
    @else
        {!! Form::text('hospital_id',$user->hospital->name,['disabled', 'class' => 'rounded-dropdown hospital']) !!}
    @endif
</div>
<div class="row">
    <label>Намерен кръв(брой донори):</label>
    <input type="text" disabled value="{{$user->current_blood}}"/>
</div>
<div class="row">
    <label>ЕГН:</label>
    <span class="warning">{{$errors->first('egn')}}</span>
    <input type="text" name="egn" value="{{$user->egn ?? old('egn')}}"/>
</div>
@if(auth()->user()->role === App\Models\User::ROLE_ADMIN)
    <div class="row text-row">
        <label>Донори:</label>
        <span class="warning">{{$errors->first('donors')}}</span>
        <select multiple="multiple" id="donors" name="donors[]">
            @foreach($donations as $donation)
                <option value="{{$donation->id}}">
                    {{$donation->donor->blood_group}},
                    {{$donation->donor->full_name}},
                    {{$donation->donor->egn}}
                    @if($donation->patient_id)
                        дарил за пациент: {{$donation->patient->full_name}}
                        с ЕГН: {{$donation->patient->egn}}
                    @endif
                </option>
            @endforeach
            @foreach($user->donors as $user)
                <option selected disabled>
                    {{$user->donor->blood_group}},
                    {{$user->donor->full_name}},
                    {{$user->donor->egn}}
                </option>
                @endforeach
        </select>
    </div>
@section('js')
    <script type="text/javascript" src="{{asset("src/js/jquery.multi-select.js")}}"></script>
    <script type="text/javascript">
        $('#donors').multiSelect({});
    </script>
@stop
@endif
{!! Form::submit($submitButtonText,['class'=>'red-btn setting-btn']) !!}
