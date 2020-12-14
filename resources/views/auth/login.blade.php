{!! Form::open(['route' => ['login'], 'method' => 'POST', 'id' => 'user-login']) !!}
{!! Form::button('X',['role' => 'button','class' => 'modal__close']) !!}
{!! Form::email('email',null,['placeholder' => 'Емайл...','class' => 'modal__email']) !!}
{!! Form::password('password',['placeholder' => 'Парола...','class' => 'modal__pass']) !!}
{!! Form::button('<i class="fas fa-heart"></i>ВЛЕЗ',['type' => 'submit','class' => 'modal__button red-btn setting-btn']) !!}
{!! Html::decode(Form::label('error','<span class="warning" id="error-login"></span>')) !!}
{!! Form::close() !!}
