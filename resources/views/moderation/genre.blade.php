@extends("layout")

@section("title") Страница жанров @endsection

@section("script")
<script>
	// Add genre
	function add_genre() {
		// Get genre
		let genre = JSON.stringify({
			"genre": document.querySelector("input[name=genre]").value
		});
		// Instantiating a request
		let xhr = new XMLHttpRequest;
		// Opening a request
		xhr.open("POST", "{{ route('genre_add') }}", true);
		// Headers
		xhr.setRequestHeader("Content-Type", "application/json");
		xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
		// Sending a request to the server
		xhr.send(genre);

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
					// Displaying the message and clearing the form
					document.querySelector(".message").innerHTML = data.message;
					document.querySelector("input[name=genre]").value = "";
					// Output of updated genres
					out_genres(data.genres);
				break;
				// Validation error
				case 422:
					for(key in data.errors)
						document.getElementById(key).innerHTML = data.errors[key][0];
				break;
			}
		};
	}

	// Delete genre
	function delete_genre() {
		// Get data
		let genre = document.querySelector("select[name=genre_id]").value;
		// Instantiating a request
		let xhr = new XMLHttpRequest;
		// Opening a request
		xhr.open("GET", "{{ route('genre_delete') }}?genre_id=" + genre, true);
		// Sending a request to the server
		xhr.send();

		// Processing query results
		xhr.onreadystatechange = function() {
			if (xhr.readyState != 4) return;
			if (xhr.responseText == "") return;
			// Data parsing
			let data = JSON.parse(xhr.responseText);
			if (xhr.status == 200) {
				// Displaying the message
				document.querySelector(".message").innerHTML = data.message;
				// Output of updated genres
				out_genres(data.genres);
			}
		};
	}

	// Output of updated genres
	function out_genres(data) {
		// Clear select
		document.querySelector("select[name=genre_id]").innerHTML = "";
		// Data concatenation
		let out = `<option disabled selected>Жанры</option>`;
		data.forEach(genre => out += `<option value="${genre.id}">${genre.genre}</option>`);
		// Data output
		document.querySelector("select[name=genre_id]").innerHTML = out;
	}
</script>
@endsection

@section("content")
	<form class="center">
		<fieldset>
			<legend>Добавление жанра</legend>
			<p class="error" id="genre"></p>
			<input type="text" name="genre" placeholder="Введите жанр">
			<input type="button" value="Добавить" onclick="add_genre()">
		</fieldset>
		<br>
		<fieldset>
			<legend>Удаление жанра</legend>
			<select name="genre_id">
				<option disabled selected>Жанры</option>
				@foreach($data->genres as $val)
					<option value="{{ $val->id }}">{{ $val->genre }}</option>
				@endforeach
			</select>
			<input type="button" value="Удалить" onclick="delete_genre()">
		</fieldset>
	</form>
@endsection