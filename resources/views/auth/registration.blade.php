{!! Form::open(['route' => ['register'], 'method' => 'POST', 'id' => 'user-register']) !!}
{!! Form::button('X',['role' => 'button','class' => 'modal__close']) !!}
{!! Form::email('email',null,['placeholder' => 'Емайл...','class' => 'modal__email']) !!}
{!! Html::decode(Form::label('error','<span class="warning" id="error-email"></span>')) !!}
{!! Form::password('password',['placeholder' => 'Парола...','class' => 'modal__pass']) !!}
{!! Html::decode(Form::label('error','<span class="warning" id="error-password"></span>')) !!}
{!! Form::password('password_confirmation',['placeholder' => 'Повторете паролата...','class' => 'modal__pass-again']) !!}
{!! Form::button('<i class="fas fa-heart"></i>РЕГИСТРИРАЙ СЕ',['type' => 'submit','class' => 'modal__button red-btn setting-btn']) !!}
{!! Form::close() !!}
