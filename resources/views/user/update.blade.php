@extends("layout")

@section("title") Обновить данные @endsection

@section("content")
	<div class="flex">
		<div class="left">
			<form action="{{ route('personal_area_update') }}" method="POST">
				<fieldset>
					<legend>Обновление данных</legend>
					{{ csrf_field() }}

					<p class="error">{{ $errors->register->first("username") }}</p>
					<input type="text" name="username" value="{{ $data->user->username }}" placeholder="Имя пользователя">

					<p class="error">{{ $errors->register->first("email") }}</p>
					<input type="text" name="email" value="{{ $data->user->email }}" placeholder="Email">

					<input type="text" value="{{ $data->user->login }}" placeholder="Логин" disabled>

					<p class="error">{{ $errors->register->first("password") }}</p>
					<input type="password" name="password" placeholder="Новый пароль">

					<p class="error">{{ $errors->register->first("password_check") }}</p>
					<input type="password" name="password_check" placeholder="Подтверждение пароля">

					<input type="submit" value="Обновить данные">
				</fieldset>
			</form>
		</div>
		<div class="right">
			<a href="{{ route('personal_area') }}"><h3>Назад</h3></a>
		</div>
	</div>
@endsection