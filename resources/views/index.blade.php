@extends("layout")

@section("title") Главная страница @endsection

@section("content")
	<div class="wrap">
		<h1>Главная страница</h1><br>

		<div class="point">
			<h3>Последние добавленные игры</h3> <hr>
			<div class="games">
				<p>Данные отсутствуют</p>
			</div>
		</div><br>

		<div class="point">
			<h3>Разработчики</h3> <hr>
			<div class="developers">
				@if(count($data->developers) == 0)
					<p>Данные отсутствуют</p>
				@else
					@foreach($data->developers as $val)
						<div class="developer">
							<a href="{{ route('developer_page', ['id' => $val->id]) }}">{{ $val->developer_title }} / {{ $val->developer_foundation }}</a>
						</div>
					@endforeach
				@endif
			</div>
		</div>

	</div>
@endsection