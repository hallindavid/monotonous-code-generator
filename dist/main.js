function code_format() {
	var source = document.getElementById("format_results_template").innerHTML;
	var template = Handlebars.compile(source);
	var Url ="/process_file_backend";
	var vFormat = document.getElementById("format_string").value;
	var vFile = document.getElementById("filename").value;

	axios({
		method: 'post',
		url: Url,
		data: {
			filename: vFile,
			format: vFormat
		}
	})
	.then(function(response) {
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

		clipboard.on('success', function(e) {
		   	alert('Copied!');
		});

	})
	.catch(err=>throw_error(err));
}

document.addEventListener("DOMContentLoaded", function(event){
  	if (document.getElementById("file_selection") != null)
	{
  		get_directory_listing();
  	}
  
  	if (document.getElementById("file_uploader") != null)
	{
	  console.log("Making Dropzone Window");
		var file_uploader = new Dropzone("div#file_uploader", { 
			url: "/upload_file",
	        addedfile: function(file) {
	        	clearError(true);
	        },
	        success: function (file, response) {
	      		console.log("Successfully uploaded file");
	      		this.removeFile(file);
	      		setTimeout(function() {
	      			get_directory_listing();
	      		},500);
	      		
	    	},
	    	error: function(file, response) {
	      		throw_error(response);
	      		this.removeFile(file);
	    	}
		});
	}
});


function throw_error(vMsg,mode='p')
{

	var source = document.getElementById("upload_error").innerHTML;
	var template = Handlebars.compile(source);
	var context = {
		message:vMsg
	};
	var html = template(context);
	var parent = document.getElementById("error_container");
	if (mode == 'replace')
	{
		//replace
		parent.innerHTML = html;
	} else {
		//prepend
		parent.innerHTML = html + parent.innerHTML;
	}
}

function clearError()
{
	document.getElementById("error_container").innerHTML = "";
}

function show_no_files_template() 
{
	if (document.getElementById("file_selection") != null)
	{
		var source = document.getElementById("no_files_template").innerHTML;
		var template = Handlebars.compile(source);
		var context = {};
		var html = template(context);
		var parent = document.getElementById("file_selection");
		parent.innerHTML = html;	
	}
}

function show_loading_files_template()
{
	if (document.getElementById("file_selection") != null)
	{
		var source = document.getElementById("loading_files_template").innerHTML;
		var template = Handlebars.compile(source);
		var context = {};
		var html = template(context);
		var parent = document.getElementById("file_selection");
		parent.innerHTML = html;
	}
}

function show_log_template(vLog, vLogCount)
{
	if (document.getElementById("log_output") != null)
	{
		var source = document.getElementById("log_template").innerHTML;
		var template = Handlebars.compile(source);
		var context = {
			log_output:vLog,
			log_count:vLogCount
		};
		var html = template(context);
		document.getElementById("log_output").innerHTML = html;
	}
}

function show_file_selection_template(context) 
{
	if (document.getElementById("file_selection") != null)
	{
		var source = document.getElementById("file_selection_template").innerHTML;
		var template = Handlebars.compile(source);
		var html = template(context);
		document.getElementById("file_selection").innerHTML = html;
	}
}

function get_directory_listing(){
	show_loading_files_template();

	console.log("Retreiving Directory Listing");
	
	axios({
		method: 'get',
		url: "/get_directory",
	})
	.then(function(response) {
		var obj = response.data;
		console.log("Received Directory Listing - Parsing/Displaying");
		
		
		console.log(obj);

		show_log_template(obj.log, obj.log_count);

		if (obj.hasFiles == "1")
		{
			var file_context = {
				files: obj.files
			}
			show_file_selection_template(file_context);
		} else {
			show_no_files_template();
		}

	})
	.catch(err=>throw_error(err));



}
	
