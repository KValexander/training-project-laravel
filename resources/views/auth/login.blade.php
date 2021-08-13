@extends("layout")

@section("title") Войти @endsection

@section("content")
		<form class="login" action="{{ route('login') }}" method="POST">
			<fieldset>
				<legend>Войти</legend>
				{{ csrf_field() }}

				<p class="error">{{ $errors->login->first() }}</p>
				<input type="text" name="login" placeholder="Логин">
				<input type="password" name="password" placeholder="Пароль">

				<input type="submit" value="Войти">

				<p class="center">Желаете <a class="underline" href="{{ route('register_page') }}">зарегистрироваться?</a></p>
			</fieldset>
		</form>
@endsection