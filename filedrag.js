
(function() {

	function $id(id) {
		return document.getElementById(id);
	}


	function Output(msg) {
		var m = $id("messages");
		m.innerHTML =  m.innerHTML + msg;
	}


	function FileDragHover(e) {
		e.stopPropagation();
		e.preventDefault();
		e.target.className = (e.type == "dragover" ? "hover" : "");
	}

	var upload = function(files)
	{
		var formData = new FormData() ;
		var xhr = new XMLHttpRequest() , x;
		for(x = 0 ; x < files.length ; x = x + 1)
		{
			formData.append('file[]' , files[x]) ;
		}
		// xhr.onreadystatechange = function()
		// {
		// 	if(xhr.readyState == 4 && xhr.status == 200)
		// 	{
		// 		document.getElementById("filedrag").innerHTML = xhr.responseText;
		// 	}
		// };
		xhr.open("POST" , "upload.php" , "true") ;
		xhr.send(formData) ;
	}

	function FileSelectHandler(e) {

		// cancel event and hover styling
		FileDragHover(e);

		// fetch FileList object
		var files = e.target.files || e.dataTransfer.files;

		// process all File objects
		for (var i = 0, f; f = files[i]; i++) {
			ParseFile(f,i);
		}

		upload(files) ;

	}


	function ParseFile(file,i) {

		document.getElementById("messa").innerHTML += 
			"<tr><td><strong>" + file.name +
			"</strong></td> <td> <strong>" + file.type +
			"</strong></td> <td><strong>" + get_size(file.size) +
			"</strong> </td><tr>" ;

	}


	function Init() {

		var fileselect = $id("fileselect"),
			filedrag = $id("filedrag"),
			submitbutton = $id("submitbutton");

		// file select
		fileselect.addEventListener("change", FileSelectHandler, false);

			filedrag.addEventListener("dragover", FileDragHover, false);
			filedrag.addEventListener("dragleave", FileDragHover, false);
			filedrag.addEventListener("drop", FileSelectHandler, false);
			filedrag.style.display = "block";

	}

	// call initialization file
	if (window.File && window.FileList && window.FileReader) {
		Init();
	}

	function  get_size(size)
	{
		var kb = size / 1024 ;
		if(size < 1024)
			return size + " B" ;
		if(kb < 1024 )
			return kb.toFixed(3) + " KB" ;
		var mb = kb / 1024 ;
		if(mb < 1024)
			return mb.toFixed(3) + " MB" ;
		var gb = mb / 1024 ;
		if(gb < 1024)
			return gb.toFixed(3) + " GB" ;
	}

})();
