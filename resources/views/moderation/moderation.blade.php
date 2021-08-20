@extends("layout")

@section("title") Страница модерации @endsection

@section("script")
<script>
	// Delete user
	function delete_user(id) {
		let check = confirm("Вы действительно хотите удалить пользователя?");
		if(check) location.href = `{{ route('moderation_delete_user') }}?user_id=${id}`;
	}

	// Search data
	function search(e, point) {
		let url, query, data;
		// Get query
		query = e.target.value;

		// Url definition
		switch(point) {
			case "users": url = "{{ route('moderation_search_users') }}?query=" + query; break;
			case "developers": url = "{{ route('moderation_search_developers') }}?query=" + query; break;
			case "games": url = "{{ route('moderation_search_games') }}?query=" + query; break;
		}

		// Instantiating a request
		let xhr = new XMLHttpRequest;
		// Opening a request
		xhr.open("GET", url, true);
		// Sending a request to the server
		xhr.send();

		xhr.onreadystatechange = function() {
			if (xhr.readyState != 4) return;
			data = JSON.parse(xhr.responseText);
			output(point, data.data);
		}
	}

	// Output search data
	function output(point, data) {
		let out = ``, name, action;
		// Handling data
		if(data.length == 0) out += `<p>Поиск ничего не нашёл</p>`;
		else {
			data.forEach(item => {
				switch(point) {
					case "users":
						name = `<a href="users/${item.id}">${item.username} / ${item.login}</a>`;
						action = `<a onclick="delete_user('${item.id}')">Удалить</a>`;
						break;
					case "developers":
						name = `<a href="developers/${item.id}">${item.developer_title}</a>`;
						if(item.state == 0) action = `<a href="{{ route('moderation_approve_developer') }}?developer_id=${item.id}">Одобрить</a>`;
						else action = `<a href="{{ route('moderation_condemn_developer') }}?developer_id=${item.id}">Отправить на модерацию</a>`;
						break;
					case "games":
						name = `<a href="">${item.game_title} / ${item.game_release}</a>`;
						if(item.state == 0) action = `<a href="{{ route('moderation_approve_game') }}?game_id=${item.id}">Одобрить</a>`;
						else action = `<a href="{{ route('moderation_condemn_game') }}?game_id=${item.id}">Отправить на модерацию</a>`;
						break;
				}
				out += `
					<div class="structure">
						<div class="name">${name}</div>
						<div class="action">${action}</div>
					</div>
				`;
			});
		}
		// Out data
		document.querySelector(`#${point} .search`).innerHTML = out;
	}
</script>
@endsection

@section("content")
	<div class="flex">
		<div class="left">
			<h2>Страница модерации</h2>
			<nav>
				<a class="underline" href="#users">Список пользователей</a> | 
				<a class="underline" href="#developers">Список разработчиков</a> | 
				<a class="underline" href="#games">Список игр</a>
			</nav>
			<br>

			<div class="point" id="users">
				<h3>Список пользователей</h3>
				<input type="text" placeholder="Поиск пользователей" oninput="search(event, 'users')">
				<hr>
				<div class="search">
					@if(count($data->users) == 0)
						<p>Данные отсутствуют</p>
					@else
						@foreach($data->users as $val)
							<div class="structure">
								<div class="name">
									<a href="{{ route('user_page', ['id' => $val->id]) }}">{{ $val->username }} / {{ $val->login }}</a>
								</div>
								<div class="action">
									<a onclick="delete_user('{{ $val->id }}')">Удалить</a>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div><br>
			
			<div class="point" id="developers">
				<h3>Список разработчиков</h3>
				<input type="text" placeholder="Поиск разработчиков" oninput="search(event, 'developers')">
				<hr>
				<div class="search">
					@if(count($data->developers) == 0)
						<p>Данные отсутствуют</p>
					@else
						@foreach($data->developers as $val)
							<div class="structure">
								<div class="name">
									<a href="{{ route('developer_page', ['id' => $val->id]) }}">{{ $val->developer_title }}</a>
								</div>
								<div class="action">
									@if($val->state == 0)
										<a href="{{ route('moderation_approve_developer', ['developer_id' => $val->id]) }}">Одобрить</a>
									@else
										<a href="{{ route('moderation_condemn_developer', ['developer_id' => $val->id]) }}">Отправить на модерацию</a>
									@endif
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div><br>

			<div class="point" id="games">
				<h3>Список игр</h3>
				<input type="text" placeholder="Поиск игр" oninput="search(event, 'games')">
				<hr>
				<div class="search">
					@if(count($data->games) == 0)
						<p>Данные отсутствуют</p>
					@else
						@foreach($data->games as $val)
							<div class="structure">
								<div class="name">
									<a href="">{{ $val->game_title }} / {{ $val->game_release }}</a>
								</div>
								<div class="action">
									@if($val->state == 0)
										<a href="{{ route('moderation_approve_game', ['game_id' => $val->id]) }}">Одобрить</a>
									@else
										<a href="{{ route('moderation_condemn_game', ['game_id' => $val->id]) }}">Отправить на модерацию</a>
									@endif
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>


		</div>
		<div class="right">
			<a href="{{ route('personal_area') }}"><h3>Назад</h3></a>
		</div>
	</div>
@endsection