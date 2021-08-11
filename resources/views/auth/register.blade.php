@extends("layout")

@section("title") Регистрация @endsection

@section("content")
	<div class="wrap">
		<form action="{{ route('register') }}" method="POST">
			<fieldset>
				<legend>Регистрация</legend>
				{{ csrf_field() }}

				<p class="error">{{ $errors->register->first("username") }}</p>
				<input type="text" name="username" placeholder="Имя пользователя">

				<p class="error">{{ $errors->register->first("email") }}</p>
				<input type="text" name="email" placeholder="Email">

				<p class="error">{{ $errors->register->first("login") }}</p>
				<input type="text" name="login" placeholder="Логин">

				<p class="error">{{ $errors->register->first("password") }}</p>
				<input type="password" name="password" placeholder="Пароль">

				<p class="error">{{ $errors->register->first("password_check") }}</p>
				<input type="password" name="password_check" placeholder="Подтверждение пароля">

				<input type="submit" value="Зарегистрироваться">

				<p class="center">Уже зарегистрированы? Тогда <a class="underline" href="{{ route('login_page') }}">войдите</a></p>
			</fieldset>
		</form>
	</div>
@endsection