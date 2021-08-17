@extends("layout")

@section("title") Страница модерации @endsection

@section("script")
<script></script>
@endsection

@section("content")
	<div class="flex">
		<div class="left">
			<h2>Страница модерации</h2>
		</div>
		<div class="right">
			<a href="{{ route('personal_area') }}"><h3>Назад</h3></a>
		</div>
	</div>
@endsection