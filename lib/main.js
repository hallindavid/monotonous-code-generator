document.addEventListener('DOMContentLoaded', () => {
	console.log("Loaded");
});

function code_format(fName) {
	var source = document.getElementById("new-template").innerHTML;
	var template = Handlebars.compile(source);

	vFormat = document.getElementById("format_string").value;

	const Url = "process_file_backend.php";

	axios({
		method: 'post',
		url: Url,
		data: {
			filename: fName,
			format: vFormat
		}
	}).then(function (response) {
		var date = new Date();
		let options = {
			weekday: "long", year: "numeric", month: "short",
			day: "numeric", hour: "2-digit", minute: "2-digit"
		};
		var context = {
			runTime: String(date.toLocaleTimeString("en-us", options)),
			body: response.data
		};
		console.log(context);
		var html = template(context);

		var parent = document.getElementById("results_set");
		parent.innerHTML = html;
		parent.scrollIntoView();
		var clipboard = new ClipboardJS('.button');

		clipboard.on('success', function (e) {
			alert('Copied!');
		});
	}).catch(err => console.log(err));
}