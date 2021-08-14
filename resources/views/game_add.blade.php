@extends("layout")

@section("title") Добавление игры @endsection

@section("script")
<script>
	function game_add() {
		// Getting form data in formdata
		let formData = new FormData(document.forms["game_add"]);

		// Instantiating a request
		let xhr = new XMLHttpRequest;
		// Opening a request
		xhr.open("POST", "{{ route('game_add') }}", true);
		// Headers
		xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
		// Sending a request to the server
		xhr.send(formData);

		// Processing query results
		xhr.onreadystatechange = function() {
			if (xhr.readyState != 4) return;
			// Data parsing
			let data = JSON.parse(xhr.responseText);
			document.querySelectorAll(".error").forEach(element => element.innerHTML = "");

			// Processing responses
			switch(xhr.status) {
				// Success
				case 200: console.log(data); break;
				// Validation error
				case 422:
					for(key in data.errors)
						document.getElementById(key).innerHTML = data.errors[key][0];
				break;
			}
		};

		// To cancel submitting form
		return false;
	}
</script>
@endsection

@section("content")
	<form class="center" id="game_add" action="{{ route('game_add') }}" onsubmit="return game_add();">
		<fieldset>
			<legend>Добавить игру</legend>
			{{ csrf_field() }}

			<p>Обложка игры</p>
			<p class="error" id="cover"></p>
			<input type="file" name="cover">

			<p class="error" id="title"></p>
			<input type="text" placeholder="Название игры" name="title">

			<p class="error" id="year_release"></p>
			<input type="number" placeholder="Год релиза" name="year_release">

			<p class="error" id="description"></p>
			<textarea placeholder="Описание" name="description"></textarea>

			<input type="submit" value="Добавить">
		</fieldset>
	</form>
@endsection