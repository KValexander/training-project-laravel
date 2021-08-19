@extends("layout")
@section("title") Страница разработчика @endsection

@section("content")
	<div class="wrap">
		<h2>Разработчик {{ $data->developer->developer_title }}</h2><br>
		<h3>Год основания: {{ $data->developer->developer_foundation }}</h3><br>
		<h3>Описание:</h3>
		<p>{{ $data->developer->developer_description }}</p>
	</div>

	<div class="wrap">
		<h2>Игры разработчика</h2><br>
		<div class="games">
			@if(count($data->games) == 0)
				<p>Данные отсутствуют</p>
			@else
				@foreach($data->games as $val)
					<div class="game">
						<a href="">
							<div class="image">
								<img src="{{ asset($val->game_cover) }}" alt="">
							</div>
							<div class="title">
								<h3>{{ $val->game_title }}</h3>
							</div>
						</a>
					</div>
				@endforeach
			@endif
		</div>
	</div>
@endsection