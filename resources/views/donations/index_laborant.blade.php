@extends('layouts.app')
@section('body')
    <div class="tabs-wrapper">
        <ul class="tabs">
            <li><a href="#tab1" class="tab-active">Получени дарения</a></li>
            <li><a href="#tab2">Изследвани дарения</a></li>
        </ul>
        <div id="tab1" class="user-info tables">
            <p class="user-info__title">Списък от дарения за изследване</p>
            <table class="table">
                <tr>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Донор</th>
                    <th>ЕГН</th>
                    <th>Пол</th>
                    <th>СПИН/ХИВ</th>
                    <th>Хепатит В</th>
                    <th>Хепатит С</th>
                    <th>Сифилис</th>
                    <th>Действие</th>
                </tr>
                @foreach($waitingDonations as $donation)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$donation->declaration_date}}</td>
                        <td>{{$donation->donor->full_name}}</td>
                        <td>{{$donation->donor->egn}}</td>
                        <td>{{$donation->donor->gender}}</td>
                        {!! Form::model($donation,['method'=>'PATCH','route'=>['donations.update.laborant',$donation]]) !!}
                        <td>{!! Form::select('hiv_spin['.$donation->id.']',$donation->results) !!}</td>
                        <td>{!! Form::select('hepatitis_b['.$donation->id.']',$donation->results) !!}</td>
                        <td>{!! Form::select('hepatitis_c['.$donation->id.']',$donation->results) !!}</td>
                        <td>{!! Form::select('syphilis['.$donation->id.']',$donation->results) !!}</td>
                        <td>{!! Form::button('Запамети',['type' => 'submit','class' => 'red-btn setting-btn']) !!}</td>
                        {!! Form::close() !!}
                    </tr>
                @endforeach
            </table>
        </div>
        <div id="tab2" class="user-info tables">
            <p class="user-info__title">Списък от изследвани дарения</p>
            <table class="table">
                <tr>
                    <th>№</th>
                    <th>Дата</th>
                    <th>Донор</th>
                    <th>ЕГН</th>
                    <th>Пол</th>
                    <th>СПИН/ХИВ</th>
                    <th>Хепатит В</th>
                    <th>Хепатит С</th>
                    <th>Сифилис</th>
                </tr>
                @foreach($donations as $donation)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$donation->result_date}}</td>
                        <td>{{$donation->donor->full_name}}</td>
                        <td>{{$donation->donor->egn}}</td>
                        <td>{{$donation->donor->gender}}</td>
                        <td>{{$donation->hiv_spin}}</td>
                        <td>{{$donation->hepatitis_b}}</td>
                        <td>{{$donation->hepatitis_c}}</td>
                        <td>{{$donation->syphilis}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop
