<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield("title")</title>
	<link rel="stylesheet" href="{{ asset('public/css/style.css') }}">
	@yield("script")
</head>
<body>

	<header>
		<div class="content">
			<div class="head">
				<a href="{{ route('main_page') }}"><h1>Games</h1></a>
				<nav>
					@if($role == "guest")
						<a href="{{ route('register_page') }}">Регистрация</a>
						<a href="{{ route('login_page') }}">Войти</a>
					@else
						<a href="{{ route('game_add_page') }}">Добавить игру</a>
						<a href="{{ route('personal_area') }}">Личный кабинет</a>
						<a href="{{ route('logout') }}">Выход</a>
					@endif
				</nav>
			</div>
		</div>
	</header>

	<div class="message">{{ $errors->message->first() }}</div>

	<main>
		<div class="content">
			@yield("content")
		</div>
	</main>

	<footer>
		<div class="content"></div>
	</footer>
	
</body>
</html>