@extends('layouts.app')
@section('body')
    <div id="regWrapper" class="mask" role="dialog"></div>
    <div id="regModal" class="modal" role="alert">
        @include('auth/registration')
    </div>
    <div id="enterWrapper" class="mask" role="dialog"></div>
    <div id="enterModal" class="modal" role="alert">
        @include('auth/login')
    </div>
    <header class="slider">
        <div class="slider__item first">
            <p class="slider__item__text">Вземане, събиране, съхранение и преработка на кръв</p>
        </div>
        <div class="slider__item second">
            <p class="slider__item__text">Подбор и изследване на кръводарители</p>
        </div>
        <div class="slider__item thirth">
            <p class="slider__item__text">Диагностика и контрол на взетите кръв и кръвни съставки</p>
        </div>
        <div class="slider__item fourth">
            <p class="slider__item__text">Осигуряване и разпределение на кръв</p>
        </div>
    </header>
    <div class="our-goal">
        <div class="our-goal__container">
            <h2>Предмет на дейност</h2>
            <p class="paralax-img fst">
                Съгласно действащото у нас специализирано законодателство, напълно синхронизирано с Европейските
                регламенти в трансфузиологията, РЦТХ - гр. Пловдив осъществява следните високо специализирани медицински
                дейности:
            </p>
            <img class="our-goal__imgf" src="./src/images/6.png" alt="Blood">
            <ul class="paralax-img sec">
                <li>Подбор и изследване на кръводарители;</li>
                <li>Вземане, събиране, съхранение и преработка на кръв;</li>
                <li>Диагностика и контрол на взетите кръв и кръвни съставки: кръвна група, резус фактор, антитела,
                    хепатит В, хепатит С, СПИН и Луес.
                </li>
                <li>Производство, съхраняване и поддържане на запаси от кръв, кръвни съставки и кръвни биопрепарати;
                </li>
                <li>Промоция и организиране на кръводаряването.</li>
                <li>Осигуряване и разпределение на кръв, кръвни съставки и кръвни биопрепарати в териториалния обхват на
                    дейност на Центъра - лечебните заведения за болнична помощ.
                </li>
                <li>Имунохематологична диагностика на пациенти.</li>
            </ul>
        </div>
    </div>
    <div class="about-us">
        <div class="about-us__left"></div>
        <div class="about-us__right"></div>
        <a style="margin-top: -10px;margin-left: -24px; position: absolute;" class="main-link" href="#">За нас</a>
        <a class="main-link" href="#"></a>
        <p>
            Районен център за трансфу- зионна хематология гр. Пловдив е ключово лечебно заведение за здравеопазването в град Пловдив и Южна България.
            Кръвният център /РЦТХ/ в Пловдив е създаден през 1951 год. и повече от 60 години функционира ежедневно, като обслужва болничните струк- тури в Пловдивска област,
            и областите Хасково, Кърджали, Смол- ян и др-ги.
        </p>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="{{asset("src/js/front-login-form.js")}}"></script>
    <script type="text/javascript" src="{{asset("src/js/front-register-form.js")}}"></script>
@stop
