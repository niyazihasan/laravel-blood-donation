<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blood Donation</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset("src/images/favicon-16x16.png")}}">
    <link href="{{asset("src/slick/slick.css")}}" rel="stylesheet">
    <link href="{{asset("src/scss/style.css")}}" rel="stylesheet">
    <link href="{{asset("src/scss/fontawesome/css/all.min.css")}}" rel="stylesheet">
    <link href="{{asset("src/multi-select.css")}}" rel="stylesheet">
    @if(Route::currentRouteName() === 'quantity.blood')
        <script type="text/javascript" src="{{asset("src/js/google-charts-loader.js")}}"></script>
        <script type="text/javascript">
            let dataJson = @json($data);
            google.charts.load('41', {packages: ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            window.onresize = drawChart;

            function drawChart() {
                let data = new google.visualization.DataTable();
                data.addColumn('string', 'Blood Type');
                data.addColumn('number', 'Наличен кръв');
                data.addColumn({type: 'number', role: 'annotation'});
                data.addColumn('number', 'Нужен кръв');
                data.addColumn({type: 'number', role: 'annotation'});
                data.addColumn('number', 'Използван кръв');
                data.addColumn({type: 'number', role: 'annotation'});
                data.addRows(dataJson);
                let options = {
                    curveType: 'function',
                    legend: 'top',
                    async: true,
                    animation: {'startup': true, duration: 1000, easing: 'out'},
                    annotations: {alwaysOutside: true},
                    hAxis: {title: 'Кръвни групи'},
                    vAxis: {title: 'Количества кръв(брой бланки)'},
                    theme: 'material'
                };
                let container = document.getElementById('chart-container');
                let chart = new google.visualization.ColumnChart(container);
                //let chart = new google.visualization.AreaChart(container);
                //let chart = new google.visualization.LineChart(container);
                chart.draw(data, options);
            }
        </script>
    @endif
</head>
<body>
<div class="big-wrapper">
    <div class="sticky-header">
        <div class="sticky-header__container">
            <a href="{{route('index')}}" class="sticky-header__container__logo">
                <img src="{{asset("src/images/ttt.png")}}">
            </a>
            <nav class="sticky-header__container__nav first-nav">
                <div class="first-nav__container">
                    @if(auth()->user())
                        @if(auth()->user()->role === App\Models\User::ROLE_ADMIN)
                            <a class="sticky-header__link main-link" href="#">ДАРИТЕЛНИ КАМПАНИИ</a>
                            <a class="sticky-header__link main-link" href="{{route('users.index')}}">ПОТРЕБИТЕЛИ</a>
                            <a class="sticky-header__link main-link"
                               href="{{route('declarations.index')}}">ДЕКЛАРАЦИИ</a>
                            <a class="sticky-header__link main-link" href="{{route('cities.index')}}">ГРАДОВЕ</a>
                            <a class="sticky-header__link main-link" href="{{route('hospitals.index')}}">БОЛНИЦИ</a>
                            <a class="sticky-header__link main-link" href="{{route('answers.step.one')}}">ДАРЕТЕ
                                КРЪВ</a>
                            <a class="sticky-header__link main-link"
                               href="{{route('patients.index')}}">СПЕШНО-ТЪРСЕЩИ</a>
                            <a class="sticky-header__link main-link" href="{{route('quantity.blood')}}">НАЛИЧНА КРЪВ</a>
                            <a class="sticky-header__link main-link" href="#">КОНТАКТИ</a>
                        @elseif(auth()->user()->role === App\Models\User::ROLE_SUPERDOCTOR)
                            <a class="sticky-header__link main-link" href="#">ДАРИТЕЛНИ КАМПАНИИ</a>
                            <a class="sticky-header__link main-link" href="{{route('declarations.index.doctor')}}">ДЕКЛАРАЦИИ</a>
                            <a class="sticky-header__link main-link" href="{{route('answers.step.one')}}">ДАРЕТЕ
                                КРЪВ</a>
                            <a class="sticky-header__link main-link"
                               href="{{route('patients.index')}}">СПЕШНО-ТЪРСЕЩИ</a>
                            <a class="sticky-header__link main-link" href="#">КОНТАКТИ</a>
                        @elseif(auth()->user()->role === App\Models\User::ROLE_DOCTOR)
                            <a class="sticky-header__link main-link" href="#">ДАРИТЕЛНИ КАМПАНИИ</a>
                            <a class="sticky-header__link main-link" href="{{route('patients.index.hospital')}}">ПАЦИЕНТИ</a>
                            <a class="sticky-header__link main-link" href="{{route('answers.step.one')}}">ДАРЕТЕ
                                КРЪВ</a>
                            <a class="sticky-header__link main-link"
                               href="{{route('patients.index')}}">СПЕШНО-ТЪРСЕЩИ</a>
                            <a class="sticky-header__link main-link" href="#">КОНТАКТИ</a>
                        @elseif(auth()->user()->role === App\Models\User::ROLE_LABORANT)
                            <a class="sticky-header__link main-link" href="#">ДАРИТЕЛНИ КАМПАНИИ</a>
                            <a class="sticky-header__link main-link" href="{{route('donations.index.laborant')}}">ИЗСЛЕДВАНИЯ</a>
                            <a class="sticky-header__link main-link" href="{{route('answers.step.one')}}">ДАРЕТЕ
                                КРЪВ</a>
                            <a class="sticky-header__link main-link"
                               href="{{route('patients.index')}}">СПЕШНО-ТЪРСЕЩИ</a>
                            <a class="sticky-header__link main-link" href="#">КОНТАКТИ</a>
                        @elseif(auth()->user()->role === App\Models\User::ROLE_USER)
                            <a class="sticky-header__link main-link" href="#">ДАРИТЕЛНИ КАМПАНИИ</a>
                            <a class="sticky-header__link main-link" href="{{route('answers.step.one')}}">ДАРЕТЕ
                                КРЪВ</a>
                            <a class="sticky-header__link main-link"
                               href="{{route('patients.index')}}">СПЕШНО-ТЪРСЕЩИ</a>
                            <a class="sticky-header__link main-link" href="#">КОНТАКТИ</a>
                        @endif
                    @else
                        <a class="sticky-header__link main-link" href="#">ДАРИТЕЛНИ КАМПАНИИ</a>
                        <a class="sticky-header__link main-link" href="#">ДАРЕТЕ КРЪВ</a>
                        <a class="sticky-header__link main-link" href="#">СПЕШНО-ТЪРСЕЩИ</a>
                        <a class="sticky-header__link main-link" href="#">КОНТАКТИ</a>
                    @endif

                </div>
            </nav>
            <nav class="sticky-header__container__nav second-nav">
                @if(!auth()->user())
                    <div class="reg-enter-wrapper">
                        <a class="sticky-header__link main-link enter" href="#">ВЛЕЗ</a>
                        <a class="sticky-header__link main-link register" href="#">РЕГИСТРИРАЙ СЕ</a>
                    </div>
                    <span class="burger-menu"><span></span>
                @else
                            <div class="profile">
                    <p class="profile__name">
                        {{auth()->user()->name !== null ? auth()->user()->name.' '.auth()->user()->surname : auth()->user()->email}}
                    <i class="angle-down fas fa-angle-down"></i>
                    </p>
                    <ul class="profile__menu">
                        <li class="profile__item"><a class="main-link" href="{{route('profile')}}">Профил</a></li>
                        <li class="profile__item"><a class="main-link" href="{{route('results')}}">Изследвания</a></li>
                        <li class="profile__item"><a class="main-link" href="{{route('logout')}}">Излез</a></li>
                    </ul>
                </div>
                @endif
            </nav>
        </div>
        @if($message = Session::get('success'))
            <div class="message">
                <p class="left"></p>
                <p class="right"></p>
                {{$message}}
                <div style="font-size: 35px;">&#9786;</div>
            </div>
        @endif
    </div>
    @yield('body')
</div>
<footer class="footer">
    <div class="footer__container">
        <div>
            <div class="footer__item">
                <a class="link main-link" href="#">Обща информация</a>
                <a class="link main-link" href="#">Полезна информация</a>
                <a class="link main-link" href="#">Актуална информация</a>
            </div>
            <div class="footer__item sec">
                <p>Град Пловдив, 4003, Бул. „България" № 234</p>
                <p>Секретар: 033 33 333; Регистратура: 044 44 444; Кръводаряване: 035 55 555;</p>
                <p>Факс: 066 66 666; E-mail: dddd@abv.bg</p>
            </div>
        </div>
        <div class="footer__social">
            <img src="{{asset("/src/images/logo1.png")}}">
            ДАРЕТЕ КРЪВ СПАСЕТЕ ЖИВОТ!!!
            <a class="facebook" href="#">
                <i class="fab fa-facebook-square"></i>
            </a>
        </div>
    </div>
</footer>
<script type="text/javascript" src="{{asset("src/js/jquery-3.3.1.min.js")}}"></script>
<script type="text/javascript" src="{{asset("src/slick/slick.min.js")}}"></script>
<script type="text/javascript" src="{{asset("src/js/main.js")}}"></script>
@yield('js')
</body>
</html>
