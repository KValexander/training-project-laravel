@extends("layout")

@section("title") Добавление игры @endsection

@section("script")
<script>
	let genres = [];

	function game_add(e) {
		// Getting form data in formdata
		let formData = new FormData(document.forms["game_add"]);
		formData.append("genres", genres);

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
				case 200:
					document.querySelector(".message").innerHTML = data;
					document.querySelector(".genres").innerHTML = "";
					genres = [];
					e.target.reset();
				break;
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

	// Add genre
	function add_genre() {
		// Get and check genre
		let genre = document.querySelector("#genre"), text = "";
		if (genre.value == "Жанры") return; if (genres.indexOf(genre.value) != -1) return;
		// Get text selected selects
		for(let i = 0; i < genre.options.length; i++)
			if (genre.options[i].value == genre.value)
				text = genre.options[i].innerText;
		// Add genre in genres
		genres.push(genre.value);
		// Output genre
		let out = `<div class="genre" onclick="delete_genre(event)">${text}</div>`;
		document.querySelector(".genres").innerHTML += out;
	}

	// Delete genre
	function delete_genre(e) {
		// Get genres
		let genre = document.querySelector("#genre"), value = -1;
		// Finding the genre
		for(let i = 0; i < genre.options.length; i++)
			if (genre.options[i].innerText == e.target.innerText)
				value = genre.options[i].value;
		// Delete genre from array genres
		let index = genres.indexOf(value);
		genres.splice(index, 1);
		// Delete div
		e.target.outerHTML = "";
	}

</script>
@endsection

@section("content")
	<form class="center" id="game_add" action="{{ route('game_add') }}" onsubmit="return game_add(event);">
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

			<p class="error" id="genres"></p>
			<div class="part">
				<select id="genre">
					<option disabled selected>Жанры</option>
					@foreach($data->genres as $val)
						<option value="{{ $val->id }}">{{ $val->genre }}</option>
					@endforeach
				</select>
				<input type="button" value="Добавить" onclick="add_genre()">
			</div>
			<div class="genres"></div>

			<p class="error" id="developer_id"></p>
			<select name="developer_id">
				<option disabled selected>Разработчик</option>
				@foreach($data->developers as $val)
					<option value="{{ $val->id }}">{{ $val->developer_title }}</option>
				@endforeach
			</select>

			<input type="submit" value="Добавить">
		</fieldset>
	</form>
@endsection