@extends("layout")

@section("title") Пользователь @endsection

@section("content")
	<div class="wrap">
		<h2>Пользователь {{ $data->user->username }}</h2>
		<br>
		<p><b>Email:</b> {{ $data->user->email }}</p>
		@if($role == "admin" || $role == "moderator")
			<p><b>Логин:</b> {{ $data->user->login }}</p>
			<p><b>Пароль:</b> {{ $data->user->password }}</p>
			<p><b>Токен:</b> {{ $data->user->remember_token }}</p>
			<p><b>Роль:</b> {{ $data->user->role }}</p>
			<p><b>Дата создания:</b> {{ $data->user->created_at }}</p>
			<p><b>Дата обновления:</b> {{ $data->user->updated_at }}</p>
		@endif
	</div>
@endsection