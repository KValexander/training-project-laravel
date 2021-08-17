@extends("layout")

@section("title") Личный кабинет @endsection

@section("script")
<script>
	function delete_user() {
		let check = confirm("Вы действительно хотите удалить страницу?");
		if(check) location.href = "{{ route('personal_area_delete') }}";
	}
</script>
@endsection

@section("content")
	<div class="flex">
		<div class="left">
			<h2>Личный кабинет</h2><br>
			<p><b>Имя пользователя:</b> {{ $data->user->username }}</p>
			<p><b>Email:</b> {{ $data->user->email }}</p>
			<p><b>Логин:</b> {{ $data->user->login }}</p>
			<p><b>Пароль:</b> {{ $data->user->password }}</p>
			<p><b>Токен:</b> {{ $data->user->remember_token }}</p>
			<p><b>Роль:</b> {{ $data->user->role }}</p>
			<p><b>Дата создания:</b> {{ $data->user->created_at }}</p>
			<p><b>Дата обновления:</b> {{ $data->user->updated_at }}</p>
		</div>
		<div class="right">
			<a href="{{ route('game_add_page') }}"><h3>Добавить игру</h3></a> <br>
			<a href="{{ route('developer_add_page') }}"><h3>Добавить разработчика</h3></a> <br>
			<a href="{{ route('personal_area_update_page') }}"><h3>Изменить данные</h3></a> <br>
			@if($role == "admin" || $role == "moderator")
				<a href="{{ route('genre_page') }}"><h3>Страница жанров</h3></a> <br>
				<a href="{{ route('moderation_page') }}"><h3>Страница модерации</h3></a> <br>
			@endif
			<a onclick="delete_user()"><h3>Удалить страницу</h3></a> <br>
		</div>
	</div>
@endsection