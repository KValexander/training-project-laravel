@extends("layout")

@section("title") Личный кабинет @endsection

@section("content")
	<div class="wrap">
		<h2>Личный кабинет</h2><br>
		<h3>{{ $data->user->username }}</h3>
	</div>
@endsection