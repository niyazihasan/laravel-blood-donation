@extends('layouts.app')
@section('body')
    <div class="tabs-wrapper">
        <ul class="tabs">
            <li><a href="#tab1" class="tab-active">Получени декларации</a></li>
            <li><a href="#tab2">Одобрени декларации</a></li>
        </ul>
        <div id="tab1" class="user-info tables">
            <p class="user-info__title">Списък от получени декларации</p>
            <table class="table">
                <tr>
                    <th>№</th>
                    <th>Име, Презиме, Фамилия</th>
                    <th>Години</th>
                    <th>ЕГН</th>
                    <th>Пол</th>
                    <th>Дата на попълване</th>
                    <th>Действия</th>
                </tr>
                @foreach($waitingDeclarations as $declaration)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$declaration->donor->full_name}}</td>
                        <td>{{$declaration->donor->age}}</td>
                        <td>{{$declaration->donor->egn}}</td>
                        <td>{{$declaration->donor->gender}}</td>
                        <td>{{$declaration->created_at}}</td>
                        <td>
                            <a class="action-btn" href="{{route('declarations.show.doctor',$declaration)}}">
                                <i class="fas fa-eye"></i> Избери
                            </a>
                            {!! Form::open(['method' => 'DELETE','route' => ['declarations.destroy.doctor', $declaration]]) !!}
                            {!! Form::button('<i class="fa fa-trash"></i> Изтрий', ['type' => 'submit', 'class' => 'action-btn']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div id="tab2" class="user-info tables">
            <p class="user-info__title">Списък от одобрени декларации</p>
            <table class="table">
                <tr>
                    <th>№</th>
                    <th>Име, Презиме, Фамилия</th>
                    <th>Години</th>
                    <th>ЕГН</th>
                    <th>Пол</th>
                    <th>Дата на попълване</th>
                    <th>Дата на одобряване</th>
                    <th>Одобрен от</th>
                    <th>Действия</th>
                </tr>
                @foreach($declarations as $declaration)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$declaration->donor->full_name}}</td>
                        <td>{{$declaration->donor->age}}</td>
                        <td>{{$declaration->donor->egn}}</td>
                        <td>{{$declaration->donor->gender}}</td>
                        <td>{{$declaration->created_at}}</td>
                        <td>{{$declaration->declaration_date}}</td>
                        <td>д-р {{$declaration->doctor->full_name}}</td>
                        <td>
                            <a class="action-btn" href="{{route('declarations.show.doctor',$declaration)}}">
                                <i class="fas fa-eye"></i> Избери
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@stop
