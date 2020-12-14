@extends('layouts.app')
@section('body')
    <div class="user-info tables">
        <p class="user-info__title">Резултати от даренията</p>
        <table class="table">
            <tr>
                <th>№</th>
                <th>Дарил за</th>
                <th>Дата</th>
                <th>СПИН/ХИВ</th>
                <th>Хепатит В</th>
                <th>Хепатит С</th>
                <th>Сифилис</th>
                <th>Изследвал</th>
            </tr>
            @foreach($donations as $donation)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        @if($donation->patient)
                            {{$donation->patient->full_name}},
                            години: {{$donation->patient->age}}
                        @else
                            Безвъзмездно
                        @endif
                    </td>
                    <td>{{$donation->result_date}}</td>
                    <td>{{$donation->hiv_spin}}</td>
                    <td>{{$donation->hepatitis_b}}</td>
                    <td>{{$donation->hepatitis_c}}</td>
                    <td>{{$donation->syphilis}}</td>
                    <td>
                        @if($donation->laborant)
                            д-р, {{$donation->laborant->full_name}}
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@stop
