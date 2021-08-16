@extends("layout")

@section("title") Добавление разработчика @endsection

@section("script")
<script>
	// Add developer
	function add_developer(e) {
		// Get form data
		let form = document.forms[0];
		// Composing object
		let dataJSON = JSON.stringify({
			"title": form.elements["title"].value,
			"year_release": form.elements["year_release"].value,
			"description": form.elements["description"].value,
		});
		// Instantiating a request
		let xhr = new XMLHttpRequest;
		// Opening a request
		xhr.open("POST", "{{ route('developer_add') }}", true);
		// Headers
		xhr.setRequestHeader("Content-Type", "application/json");
		xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}");
		// Sending a request to the server
		xhr.send(dataJSON);

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
					document.querySelector(".message").innerHTML = data;
					e.target.reset();
				break;
				// Validation error
				case 422:
					for(key in data.errors)
						document.getElementById(key).innerHTML = data.errors[key][0];
				break;
			}
		};
		return false;
	}
</script>
@endsection

@section("content")

	<form class="center" onsubmit="return add_developer(event);">
		<fieldset>
			<legend>Добавить разработчика</legend>

			<p class="error" id="title"></p>
			<input type="text" placeholder="Название" name="title">

			<p class="error" id="year_release"></p>
			<input type="number" placeholder="Год основания" name="year_release">

			<p class="error" id="description"></p>
			<textarea name="description" placeholder="Описание"></textarea>

			<input type="submit" value="Добавить разработчика">

		</fieldset>
	</form>

@endsection